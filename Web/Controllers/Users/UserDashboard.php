<?php

namespace Lc5\Web\Controllers\Users;

use Lc5\Web\Controllers\Users;
use CodeIgniter\I18n\Time;
use Lc5\Data\Models\SiteUsersModel;
use Lc5\Data\Entities\SiteUser;



class UserDashboard extends UserMaster
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// // 
		// $this->user_tools = new UserTools();
		// $this->has_active_subscription = $this->user_tools->get_has_active_subscription();
		// // 
		// $this->web_ui_date->__set('request', $this->req);
		// // 
		// $this->page_data_arr = [
		// 	'logged_user' => $this->user_tools->get_current_user(),
		// 	'user_profile' => $this->user_tools->get_current_profile(),
		// 	'user_subscription' => $this->user_tools->get_current_subscription(),
		// 	'has_active_subscription' => $this->has_active_subscription,
		// 	'backend_menu' => $this->getBackendMenu('dashboard'),
		// 	'seo_title' => 'Prime Tutor',
		// ];

		// 
	}

	//--------------------------------------------------------------------
	public function personalDashboard()
	{
		$curr_entity = (object) [
			'titolo' => 'Benvenuto',
			'descrizione' => '',
			'type' => 'user_dashboard'
		];

		if (!$logged_user = $this->user_tools->get_current_user()) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// if (!$logged_profile = $this->user_tools->get_current_profile()) {
		// 	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		// }

		$this->web_ui_date->__set('logged_user', $logged_user);
		// $this->web_ui_date->__set('user_profiles', $logged_profile);
		// // 
		// $lezioni_viste_model = new LezioniVisteModel();
		// $lezioni_viste_count = $lezioni_viste_model
		// 	->where('user_id', $logged_user->id)
		// 	->where('user_profile_id', $logged_profile->id)
		// 	->countAllResults();
		// $lezioni_viste = $lezioni_viste_model->asObject()->orderBy('updated_at', 'desc')
		// 	->where('user_id', $logged_user->id)
		// 	->where('user_profile_id', $logged_profile->id)
		// 	->findAll(5);
		// $this->web_ui_date->__set('lezioni_viste', $lezioni_viste);
		// $this->web_ui_date->__set('lezioni_viste_count', $lezioni_viste_count);
		// // 
		// $quizs_fatti_model = new QuizsFattiModel();
		// $quiz_fatti_count = $quizs_fatti_model
		// 	->where('user_id', $logged_user->id)
		// 	->where('user_profile_id', $logged_profile->id)
		// 	->countAllResults();
		// $quiz_fatti = $quizs_fatti_model->asObject()->orderBy('updated_at', 'desc')
		// 	->where('user_id', $logged_user->id)
		// 	->where('user_profile_id', $logged_profile->id)
		// 	->findAll(5);
		// $this->web_ui_date->__set('quiz_fatti', $quiz_fatti);
		// $this->web_ui_date->__set('quiz_fatti_count', $quiz_fatti_count);
		// 
		// 
		$this->web_ui_date->fill((array)$curr_entity);
		// 
		// 
		if (isset($this->custom_app_contoller) && $this->custom_app_contoller) {
			$custom_app_contoller_method = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[\s_]+/', ' ', str_replace(['-', '_'], ' ', $curr_entity->type)))));
			if (method_exists($this->custom_app_contoller, $custom_app_contoller_method)) {
				$this->custom_app_contoller->{$custom_app_contoller_method}($this);
			}
		}
		//
		if (appIsFile($this->base_view_filesystem . 'users/user-dashboard.php')) {
			return view($this->base_view_namespace . 'users/user-dashboard', $this->web_ui_date->toArray());
		} else {
			$this->base_view_namespace = $this->lc5_views_namespace;
			$this->web_ui_date->__set('base_view_folder', $this->base_view_namespace);
			return view($this->base_view_namespace . 'users/user-dashboard', $this->web_ui_date->toArray());
		}
	}


	//--------------------------------------------------------------------
	public function login()
	{
		$curr_entity = (object) [
			'titolo' => 'Login',
			'descrizione' => 'Login',
			'type' => 'user_login'
		];
		if ($this->user_tools->is_logged_in()) {
			return redirect()->route('web_dashboard');
		}


		$users_model = new SiteUsersModel();
		$request = \Config\Services::request();
		$this->web_ui_date->__set('request', $request);
		// 
		if ($request->getMethod() == 'post') {
			$validate_rules = [
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
				'password' => ['label' => 'Password', 'rules' => 'required']
			];
			// 	$curr_entity->fill($request->getPost());
			if ($this->validate($validate_rules)) {
				$user = $users_model->orderBy('created_at', 'DESC')->where('email', $request->getPost('email'))->first(); //->where('status', 1)
				if ($user) {
					if (password_verify($request->getPost('password'), $user->password)) {
						if ($user->status == 1) {
							// 
							$this->user_tools->setUserSession($user);
							$up_data = [
								'last_login' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss'),
							];
							$users_model->update($user->id, $up_data);
							//
							session()->setFlashdata('ui_mess', NULL);
							session()->setFlashdata('ui_mess_type', NULL);
							if ($get_redirect = $request->getGet('returnTo')) {
								return redirect()->to(urldecode($get_redirect));
							} else {
								return redirect()->route('web_dashboard');
							}
						} else {
							session()->setFlashdata('ui_mess', '<b>Utente non attivo.</b><br />Ti abbiamo invato una email con link per effettuare la verifica del tuo account.');
							session()->setFlashdata('ui_mess_type', 'alert alert-danger');
						}
					} else {
						session()->setFlashdata('ui_mess', 'Nome utente o password errati');
						session()->setFlashdata('ui_mess_type', 'alert alert-danger');
					}
				} else {
					session()->setFlashdata('ui_mess', 'Nome utente o password errati');
					session()->setFlashdata('ui_mess_type', 'alert alert-danger');
				}
			} else {
				session()->setFlashdata('ui_mess', $this->validator->getErrors());
				session()->setFlashdata('ui_mess_type', 'alert alert-danger');
			}
		}
		// 

		// 
		$this->web_ui_date->fill((array)$curr_entity);
		// 
		// 
		if (isset($this->custom_app_contoller) && $this->custom_app_contoller) {
			$custom_app_contoller_method = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[\s_]+/', ' ', str_replace(['-', '_'], ' ', $curr_entity->type)))));

			if (method_exists($this->custom_app_contoller, $custom_app_contoller_method)) {
				$this->custom_app_contoller->{$custom_app_contoller_method}($this);
			}
		}
		//
		if (appIsFile($this->base_view_filesystem . 'users/login.php')) {
			return view($this->base_view_namespace . 'users/login', $this->web_ui_date->toArray());
		} else {
			$this->base_view_namespace = $this->lc5_views_namespace;
			$this->web_ui_date->__set('base_view_folder', $this->base_view_namespace);
			return view($this->base_view_namespace . 'users/login', $this->web_ui_date->toArray());
		}
	}

	//--------------------------------------------------------------------
	public function signUp()
	{
		helper('text');
		$curr_entity = (object) [
			'titolo' => 'ISCRIVITI',
			'descrizione' => '',
			'type' => 'user_sign_up'
		];
		if ($this->user_tools->is_logged_in()) {
			return redirect()->route('web_dashboard');
		}


		$users_model = new SiteUsersModel();
		$entity = new SiteUser();
		$request = \Config\Services::request();
		$this->web_ui_date->__set('request', $request);
		// 
		if ($request->getMethod() == 'post') {
			$validate_rules = [
				'name' => ['label' => 'Nome', 'rules' => 'required'],
				'surname' => ['label' => 'Cognome', 'rules' => 'required'],
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
				'new_password' => ['label' => 'Password', 'rules' => 'required|min_length[8]'],
				'confirm_new_password' => ['label' => 'Conferma Password', 'rules' => 'required|matches[new_password]'],
				// 'cf' => ['label' => 'Codice Fiscale', 'rules' => 'required|regex_match['.$this->redex_codfis.']'],
				't_e_c' => ['label' => 'Termini e condizioni', 'rules' => 'required'],
			];
			$entity->fill($request->getPost());


			if ($this->validate($validate_rules)) {
				if ($check_email_exist = $users_model->orderBy('created_at', 'DESC')->where('email', $request->getPost('email'))->where('status', 1)->first()) {
					session()->setFlashdata('ui_mess', 'Indirizzo email già presente');
					session()->setFlashdata('ui_mess_type', 'alert alert-danger');
				} else {
					$entity->password = $entity->new_password;
					$entity->activation_token = random_string('alnum', 12) . '-' . random_string('alnum', 24) . '-' . random_string('alnum', 12) . '-' . random_string('alnum', 6);
					$users_model->save($entity);
					// 
					$new_id = $users_model->getInsertID();
					//
					// 
					//
					$body_params = [
						'name' => $entity->name,
						'surname' => $entity->surname,
						'email' => $entity->email,
						'activation_link' => site_url(route_to('web_attiva_account', $entity->activation_token)),
					];
					$htmlbody = file_get_contents(APPPATH . 'Views/email/attiva_account.html');
					$htmlbody = str_replace('{{name}}', $body_params['name'], $htmlbody);
					$htmlbody = str_replace('{{surname}}', $body_params['surname'], $htmlbody);
					$htmlbody = str_replace('{{email}}', $body_params['email'], $htmlbody);
					$htmlbody = str_replace('{{activation_link}}', $body_params['activation_link'], $htmlbody);
					$email_subject = 'Benvenuto in ' . env('custom.app_name') . ' - Verifica il tuo account';
					if ($this->sendAccountVerificationEmail($entity->email, $email_subject, $htmlbody)) {
						// if ($this->sendAccountVerificationEmail($entity->email, $entity->name . ' ' . $entity->surname, $this->from_address, $this->from_name, $email_subject, $htmlbody, $body_params)) {
						session()->setFlashdata('ui_mess', 'Ti abbiamo inviato una mail per poter verificare i tuoi dati e attivare il tuo account.');
						session()->setFlashdata('ui_mess_type', 'alert alert-ok');
						return redirect()->route('web_login');
					} else {
						session()->setFlashdata('ui_mess', 'Si è verificato un errore durante l\'invio della mail di verifica');
						session()->setFlashdata('ui_mess_type', 'alert alert-danger');
					}
					// 
				}
			} else {
				session()->setFlashdata('ui_mess', $this->validator->getErrors());
				session()->setFlashdata('ui_mess_type', 'alert alert-danger');
			}
		}
		// 
		// 
		$this->web_ui_date->fill((array)$curr_entity);
		// 
		// 
		if (isset($this->custom_app_contoller) && $this->custom_app_contoller) {
			$custom_app_contoller_method = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[\s_]+/', ' ', str_replace(['-', '_'], ' ', $curr_entity->type)))));

			if (method_exists($this->custom_app_contoller, $custom_app_contoller_method)) {
				$this->custom_app_contoller->{$custom_app_contoller_method}($this);
			}
		}
		//
		if (appIsFile($this->base_view_filesystem . 'users/sign_up.php')) {
			return view($this->base_view_namespace . 'users/sign_up', $this->web_ui_date->toArray());
		} else {
			$this->base_view_namespace = $this->lc5_views_namespace;
			$this->web_ui_date->__set('base_view_folder', $this->base_view_namespace);
			return view($this->base_view_namespace . 'users/sign_up', $this->web_ui_date->toArray());
		}
	}

	//--------------------------------------------------------------------
	public function attivaAccount($activation_token)
	{
		$curr_entity = (object) [
			'titolo' => 'ISCRIVITI',
			'descrizione' => '',
			'type' => 'user_attiva_account'
		];
		if ($this->user_tools->is_logged_in()) {
			return redirect()->route('web_dashboard');
		}



		$users_model = new SiteUsersModel();
		$request = \Config\Services::request();
		$this->web_ui_date->__set('request', $request);
		$user = $users_model->where('activation_token', $activation_token)->first();
		if (!$user) {
			$curr_entity->titolo = 'Utente non trovato';
			$this->web_ui_date->fill((array)$curr_entity);
			// 
			//
			if (appIsFile($this->base_view_filesystem . 'users/user-mess.php')) {
				return view($this->base_view_namespace . 'users/user-mess', $this->web_ui_date->toArray());
			} else {
				$this->base_view_namespace = $this->lc5_views_namespace;
				$this->web_ui_date->__set('base_view_folder', $this->base_view_namespace);
				return view($this->base_view_namespace . 'users/user-mess', $this->web_ui_date->toArray());
			}
		}
		$user->activated_at =  Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss');
		$user->status = 1;
		$user->activation_token = NULL;
		if ($users_model->save($user)) {
			session()->setFlashdata('ui_mess', 'Il tuo account è stato attivato correttamente.');
			session()->setFlashdata('ui_mess_type', 'alert alert-ok');
			return redirect()->to(route_to('web_login'));
		} else {
			session()->setFlashdata('ui_mess', 'Si è verificato un errore durate.');
			session()->setFlashdata('ui_mess_type', 'alert alert-danger');
		}
		// 
		// 
		$this->web_ui_date->fill((array)$curr_entity);
		// 
		// 
		if (isset($this->custom_app_contoller) && $this->custom_app_contoller) {
			$custom_app_contoller_method = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[\s_]+/', ' ', str_replace(['-', '_'], ' ', $curr_entity->type)))));

			if (method_exists($this->custom_app_contoller, $custom_app_contoller_method)) {
				$this->custom_app_contoller->{$custom_app_contoller_method}($this);
			}
		}
		//
		if (appIsFile($this->base_view_filesystem . 'users/user-mess.php')) {
			return view($this->base_view_namespace . 'users/user-mess', $this->web_ui_date->toArray());
		} else {
			$this->base_view_namespace = $this->base_view_namespace;
			$this->web_ui_date->__set('base_view_folder', $this->base_view_namespace);
			return view($this->base_view_namespace . 'users/user-mess', $this->web_ui_date->toArray());
		}
	}

	//--------------------------------------------------------------------
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	public function recuperaPasswordS1($action = null)
	{
		if ($action == 'avviata' || $action == 'avviatav2') {
			$this->page_data_arr['titolo'] = 'Modifica password';
			$this->page_data_arr['descrizione'] = 'Ti abbiamo inviato una email.<br />Troverai tutte le istruzioni per avviare la procedura di modifica password.';
			$this->web_ui_date->fill($this->page_data_arr);
			// 
			return view($this->module_views_folder . 'user-mess', $this->web_ui_date->toArray());
		}

		helper('text');
		$users_model = new SiteUsersModel();
		$request = \Config\Services::request();
		// 
		if ($request->getMethod() == 'post') {
			$validate_rules = [
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
			];
			if ($this->validate($validate_rules)) {
				if ($entity = $users_model->orderBy('created_at', 'DESC')->where('email', $request->getPost('email'))->where('status', 1)->first()) {

					$entity->password = random_string('alnum', 12) . '-' . random_string('alnum', 24) . '-' . random_string('alnum', 12) . '-' . random_string('alnum', 6);
					$entity->status = 2;
					$entity->activation_token = random_string('alnum', 12) . '-' . random_string('alnum', 24) . '-' . random_string('alnum', 12) . '-' . random_string('alnum', 6);
					$users_model->save($entity);
					// 
					//
					$body_params = [
						'name' => $entity->name,
						'surname' => $entity->surname,
						'email' => $entity->email,
						'logo_path' => site_url('/assets/img/primetutor-bianco.png'),
						'activation_link' => site_url(route_to('web_recupera_password_s2', $entity->activation_token)),
					];
					$htmlbody = file_get_contents(APPPATH . 'Views/email/recupera_password.html');
					$email_subject = 'Prime Tutor - modifica password';
					if ($this->sendToUserEmail($entity->email, $entity->name . ' ' . $entity->surname, $this->from_address, $this->from_name, $email_subject, $htmlbody, $body_params)) {
						return redirect()->route('web_recupera_password_s1_action', ['avviata']);
					} else {
						session()->setFlashdata('ui_mess', 'Si è verificato un errore durante l\'invio della email');
						session()->setFlashdata('ui_mess_type', 'alert alert-danger');
					}
					// 
				} else {
					session()->setFlashdata('ui_mess', 'Utente non trovato. Controlla i dati inseriti');
					session()->setFlashdata('ui_mess_type', 'alert alert-danger');
				}
			} else {
				session()->setFlashdata('ui_mess', $this->validator->getErrors());
				session()->setFlashdata('ui_mess_type', 'alert alert-danger');
			}
		} else {
			session()->setFlashdata('ui_mess', null);
			session()->setFlashdata('ui_mess_type', null);
		}
		// 
		$this->web_ui_date->fill($this->page_data_arr);
		// 
		return view($this->base_view_namespace . 'recupera-password-s1', $this->web_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function recuperaPasswordS2($activation_token)
	{

		$users_model = new SiteUsersModel();
		$entity = $users_model->where('activation_token', $activation_token)->first();
		if (!$entity) {
			$this->page_data_arr['titolo'] = 'Utente non trovato';
			$this->web_ui_date->fill($this->page_data_arr);
			// 
			return view($this->base_view_namespace . 'user-mess', $this->web_ui_date->toArray());
		}

		helper('text');
		$users_model = new SiteUsersModel();
		$request = \Config\Services::request();
		// 
		if ($request->getMethod() == 'post') {
			$validate_rules = [
				'new_password' => ['label' => 'Password', 'rules' => 'required|min_length[8]'],
				'confirm_new_password' => ['label' => 'Conferma Password', 'rules' => 'required|matches[new_password]'],
			];

			$entity->fill($request->getPost());


			if ($this->validate($validate_rules)) {

				$entity->password = $entity->new_password;
				$entity->status = 1;
				$entity->activation_token = NULL;
				$users_model->save($entity);
				// 
				return redirect()->route('web_login');
			} else {
				session()->setFlashdata('ui_mess', $this->validator->getErrors());
				session()->setFlashdata('ui_mess_type', 'alert alert-danger');
			}
		}
		// 
		$this->web_ui_date->fill($this->page_data_arr);
		// 
		return view($this->module_views_folder . 'recupera-password-s2', $this->web_ui_date->toArray());
	}


	//--------------------------------------------------------------------
	public function logout()
	{
		$this->user_tools->destroyUserSession();
		return redirect()->route('web_homepage');
	}


	//--------------------------------------------------------------------
	public function vediEmailTemplate($view_filename)
	{
		helper('text');

		$htmlbody = file_get_contents(APPPATH . 'Views/email/' . $view_filename . '.html');
		$___activation_token = random_string('alnum', 12) . '-' . random_string('alnum', 24) . '-' . random_string('alnum', 12) . '-' . random_string('alnum', 6);

		$htmlbody = str_replace('{name}', 'Nooome', $htmlbody);
		$htmlbody = str_replace('{surname}', 'Cognome', $htmlbody);
		$htmlbody = str_replace('{email}', 'email.email.email@email.it', $htmlbody);
		$htmlbody = str_replace('{logo_path}', site_url('/assets/img/primetutor-bianco.png'), $htmlbody);
		$htmlbody = str_replace('{activation_link}', site_url(route_to('web_recupera_password_s2', $___activation_token)), $htmlbody);



		return $htmlbody;
		// return view('Views/email/'. $view_filename . '.html');

	}

	//--------------------------------------------------------------------

}
