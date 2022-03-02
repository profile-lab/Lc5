<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\AdminsModel;

use Lc5\Data\Entities\LoginDati;
use stdClass;

class Admins extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
	}

	//--------------------------------------------------------------------
	public function login()
	{
		$request = \Config\Services::request();
		// 
		$admins_model = new AdminsModel();
		$curr_entity = new LoginDati();
		// 
		if ($request->getMethod() == 'post') {
			$validate_rules = [
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
				'password' => ['label' => 'Password', 'rules' => 'required']
			];
			$is_falied = TRUE;
			$curr_entity->fill($request->getPost());
			if ($this->validate($validate_rules)) {
				$user = $admins_model->where('email', $request->getPost('email'))->where('status', 1)->first();
				if ($user) {
					if (password_verify($request->getPost('password'), $user->password)) {
						$this->setUserSession($user);
						$is_falied = FALSE;
						if ($get_redirect = $request->getGet('returnTo')) {
							return redirect()->to(urldecode($get_redirect));
						} else {
							return redirect()->route('lc_dashboard');
						}
					}
				} else {
					$errMess = 'Utente non trovato';
				}
			} else {
				$errMess = $this->lc_parseValidator($this->validator->getErrors());
			}
			if ($is_falied) {
				$ui_mess =  ((isset($errMess)) ? $errMess : 'Utente non trovato! Controlla i dati inseriti!');
				$ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$data = [
			'ui_mess' => (isset($ui_mess)) ? $ui_mess : '',
			'ui_mess_type' => (isset($ui_mess_type)) ? $ui_mess_type : '',
			'formdata' => $curr_entity
		];
		return view('Lc5\Cms\Views\login', $data);
	}
	//--------------------------------------------------------------------
	public function firstLogin()
	{
		$request = \Config\Services::request();
		// 
		$admins_model = new AdminsModel();
		// 
		$check_is_primo = $admins_model->select('id')->where('status', 1)->first();
		if ($check_is_primo) {
			return redirect()->route('lc_login');
		}
		// 

		$curr_entity = new LoginDati();
		if ($request->getMethod() == 'post') {
			$validate_rules = [
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
				'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]']
			];
			$is_falied = TRUE;
			$curr_entity->fill($request->getPost());
			$curr_entity->name = 'AppAdmin';
			$curr_entity->status = 1;
			$curr_entity->id_app = 1;
			if ($this->validate($validate_rules)) {
				$user = $admins_model->where('email', $request->getPost('email'))->where('status', 1)->first();
				if ($user) {
					$errMess = 'Utente trovato';
				} else {
					$admins_model->save($curr_entity);
					return redirect()->route('lc_login');
				}
			} else {
				$errMess = $this->lc_parseValidator($this->validator->getErrors());
			}
			if ($is_falied) {
				$ui_mess =  ((isset($errMess)) ? $errMess : 'Utente non trovato! Controlla i dati inseriti!');
				$ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$data = [
			'ui_mess' => (isset($ui_mess)) ? $ui_mess : '',
			'ui_mess_type' => (isset($ui_mess_type)) ? $ui_mess_type : '',
			'formdata' => $curr_entity
		];
		return view('Lc5\Cms\Views\login', $data);
	}

	//--------------------------------------------------------------------
	public function logout()
	{
		$data = [
			'admin_id' => NULL,
			'admin_data' => NULL,
			'isAdminLoggedIn' => FALSE,
			'curr_lc_lang' => NULL,
			'curr_lc_app' => NULL,
		];
		session()->set($data);
		// session()->destroy();
		return redirect()->route('lc_login');
	}

	//--------------------------------------------------------------------
	public function user_id()
	{
		if ($userID = session()->get('admin_id')) {
			return $userID;
		}
		return null;
	}

	//--------------------------------------------------------------------
	public function get_current_user()
	{
		if ($user_data = session()->get('admin_data')) {
			return $user_data;
		}
		return null;
	}

	//--------------------------------------------------------------------
	public function is_logged_in()
	{
		if ($is_logged_in = session()->get('isAdminLoggedIn')) {
			return $is_logged_in;
		}
		return FALSE;
	}

	//--------------------------------------------------------------------
	private function setUserSession($user)
	{

		
		$data = [
			'admin_id' => $user->id,
			'admin_data' => [
				'id' => $user->id,
				'email' => $user->email,
				'nome' => $user->name,
				'wellcome_mess' => 'Ciao ' . $user->name,
			],
			'isAdminLoggedIn' => true,
			'curr_lc_lang' => $this->getDefaultLang(),
			'curr_lc_app' => $this->getDefaultApp(),
		];
		session()->set($data);
		return true;
	}


	//--------------------------------------------------------------------
	public function index()
	{
		return view('welcome_message');
	}
}
