<?php

namespace Lc5\Web\Controllers;

use App\Controllers\BaseController;
use Lc5\Data\Entities\WebUiData;

use Lc5\Data\Models\RowsModel;
use Lc5\Data\Models\MediaModel;
use Lc5\Data\Models\PostsModel;
use Lc5\Data\Models\PostscategoriesModel;
use Lc5\Data\Models\PostTagsModel;
use Lc5\Data\Models\PoststypesModel;
use stdClass;

use CodeIgniter\Email\Email;

use function PHPUnit\Framework\fileExists;

// use Mailgun\Mailgun;

class MasterApp extends BaseController
{

    protected $exclude_maintenance_paths = ['add-maintainer', 'payment-stripe-webhook'];


	protected $redex_codfis = "/^(?:[A-Z][AEIOU][AEIOUX]|[AEIOU]X{2}|[B-DF-HJ-NP-TV-Z]{2}[A-Z]){2}(?:[\dLMNP-V]{2}(?:[A-EHLMPR-T](?:[04LQ][1-9MNP-V]|[15MR][\dLMNP-V]|[26NS][0-8LMNP-U])|[DHPS][37PT][0L]|[ACELMRT][37PT][01LM]|[AC-EHLMPR-T][26NS][9V])|(?:[02468LNQSU][048LQU]|[13579MPRTV][26NS])B[26NS][9V])(?:[A-MZ][1-9MNP-V][\dLMNP-V]{2}|[A-M][0L](?:[1-9MNP-V][\dLMNP-V]|[0L][1-9MNP-V]))[A-Z]$/i";



	protected $route_prefix;
	protected $module_name;
	protected $req;

	protected $is_api = false;

	public $custom_app_contoller = null;

	protected $send_mail_config;
    protected $form_result = null;
    protected $form_post_data = null;


	//--------------------------------------------------------------------
	public function __construct()
	{
        // d(MasterApp::class);
		$this->req = \Config\Services::request();
		$locale = $this->req->getLocale();
		if(!defined('__locale__')){
			define('__locale__', $locale);
		}
		if(!defined('__default_locale__')){
			define('__default_locale__', $this->req->getDefaultLocale());
		}
		if(!defined('__locale_uri__')){
			define('__locale_uri__', (__locale__ != getenv('app.defaultLocale')) ? __locale__ : '');
		}
        // 
		if(!defined('__web_app_id__')){
			define('__web_app_id__', getenv('custom.web_app_id'));
		}
		if(!defined('__post_per_page__')){
			define('__post_per_page__', (getenv('custom.post_per_page')) ?: 25);
		}
		// 
		$this->send_mail_config = $this->getEnvEmailConfig();
		// 


		


		if (file_exists(APPPATH . 'Controllers/CustomAppContoller.php')) {
			$this->custom_app_contoller = new \App\Controllers\CustomAppContoller($this);
		}


		if ($this->req->getPost()) {
			if (file_exists(APPPATH . 'Controllers/CustomAppContoller.php') &&  method_exists($this->custom_app_contoller, 'parseFormPostData')) {
				$form_result = $this->custom_app_contoller->{'parseFormPostData'}($this->req->getPost());
				$this->form_result = $form_result;
			} else {
				$form_result = $this->parseFormPostData($this->req->getPost());
                $this->form_result = $form_result;
			}
			$form_post_data = (object) $this->req->getPost();
            $this->form_post_data = $form_post_data;
		}
	}

	//--------------------------------------------------------------------
	private function parseFormPostData($post_data = null)
	{
		if ($post_data) {
			if (isset($post_data['send_action'])) {
				switch ($post_data['send_action']) {
					case 'sendmailtoinfo':
						return $this->sendMailToInfo();
						break;
				}
			}
		}
		return FALSE;
	}
	//--------------------------------------------------------------------
	private function sendMailToInfo()
	{
		$requestService = $this->req = \Config\Services::request();
		$post_data = $requestService->getPost();
		// 
		$return_obj = new stdClass();
		$return_obj->is_send = FALSE;
		$user_mess = new stdClass();
		$user_mess->type = 'ko';
		$user_mess->title = $this->appLabelMethod('Si è verificato un errore', $this->web_ui_date->app->labels);
		$user_mess->content = '';
		if ($post_data) {
			if (isset($post_data['to_addres'])) {
				$toAddress = $post_data['to_addres'];
			} else {
				$toAddress = env('custom.default_to_address');
			}
			if (isset($post_data['checkfield'])) {
				$checkfield_arr = explode('|', $post_data['checkfield']);
				if (is_array($checkfield_arr) && count($checkfield_arr) > 0) {
					$field_errors = [];
					$field_errors_html_list = '';
					foreach ($checkfield_arr as $field_to_check) {
						if (!isset($post_data[$field_to_check]) || !trim($post_data[$field_to_check])) {
							$field_errors[$field_to_check] = 'richiesto';
							$field_errors_html_list .= '<li>Il campo <b>' . $field_to_check . '</b> è richiesto</li>';
						}
					}
					if (count($field_errors) > 0) {
						$user_mess->title = $this->appLabelMethod("Errore!. Controlla i campi richiesti", $this->web_ui_date->app->labels);
						$user_mess->content = $this->appLabelMethod("<ul>" . $field_errors_html_list . "</ul>", $this->web_ui_date->app->labels);
						$return_obj->user_mess = $user_mess;
						return $return_obj;
					}
				}
			} else {
				throw new \Exception("Error Processing Request. Checkfield is required", 1);
			}

			// return;


			$htmlbody = file_get_contents(APPPATH . 'Views/email/info_request.html');
			$htmlbody = str_replace('{{logo_path}}', env('custom.logo_path'), $htmlbody);
			$htmlbody = str_replace('{{app_name}}', env('custom.app_name'), $htmlbody);
			$htmlbody = str_replace('{{name}}', $post_data['name'], $htmlbody);
			$htmlbody = str_replace('{{surname}}', $post_data['surname'], $htmlbody);
			$htmlbody = str_replace('{{email}}', $post_data['email'], $htmlbody);
			$htmlbody = str_replace('{{tel}}', $post_data['tel'], $htmlbody);
			$htmlbody = str_replace('{{message}}', nl2br($post_data['message']), $htmlbody);
			$email_subject = 'Richiesta info da ' . '=?UTF-8?B?'.base64_encode(env('custom.app_name')).'?=';
			if ($this->inviaEmail($toAddress, $email_subject, $htmlbody)) {
				$user_mess->type = 'ok';
				$user_mess->title = $this->appLabelMethod('Email inviata con successo', $this->web_ui_date->app->labels);
				$user_mess->content = $this->appLabelMethod('La sua richiesta è stata presa in carico dal nostro team. Grazie!', $this->web_ui_date->app->labels);
				$return_obj->is_send = TRUE;
			} else {
				$user_mess->title = $this->appLabelMethod("Si è verificato un errore durante l'invio della mail", $this->web_ui_date->app->labels);
				$user_mess->content = $this->appLabelMethod("L'errore è stato segnalato e stiamo lavorando per risolvere il problema, riprova più tardi", $this->web_ui_date->app->labels);
			}
		}
		$return_obj->user_mess = $user_mess;
		return $return_obj;
	}

	

	//--------------------------------------------------------------------
	protected function getEntityRows($parent, $modulo)
	{
		// 
		$rows_model = new RowsModel();
		$rows_model->setForFrontemd();
		$media_model = new MediaModel();
		$media_model->setForFrontemd();

		// 
		$processedRow = $rows_model
			->asObject()
			->orderBy('ordine', 'ASC')
			->where('parent', $parent)
			->where('modulo', $modulo)
			->findAll();
		foreach ($processedRow as $row) {
			if (isset($row->json_data) && $row->json_data && $row->json_data != '') {
				$row->data_object = json_decode($row->json_data);
				if ($row->data_object && is_iterable($row->data_object)) {
					foreach ($row->data_object as $data_object_item) {
						$data_object_item->guid = url_title($data_object_item->title, '-', TRUE);
						// 
						$data_object_item->img_path = null;
						$data_object_item->img_obj = null;
						if (isset($data_object_item->img_id) && $data_object_item->img_id > 0) {
							if ($data_object_item->img_obj = $media_model->find($data_object_item->img_id)) {
								$data_object_item->img_path = $data_object_item->img_obj->path;
							}
						}
						// 
					}
				}
			}
			// 
			$custom_parameters = null;
			if (isset($row->free_values_object) && is_array($row->free_values_object) && count($row->free_values_object) > 0) {
				$custom_parameters = new stdClass();
				foreach ($row->free_values_object as $free_val) {
					$row->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
					$custom_parameters->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
				}
			}
			$row->custom_parameters = $custom_parameters;
			// 
			$row->guid = url_title($row->nome, '-', TRUE);
			if ($row->type != 'component') {
				if($viewFilePath = customOrDefaultViewFragment('rows/' . $row->type . '-' . $row->css_class, 'Lc5', false)){
					$row->view = $viewFilePath;
				}else{
					$row->view = customOrDefaultViewFragment('rows/' . $row->type, 'Lc5');
				}
			} else {
				if($viewFilePath = customOrDefaultViewFragment('rows/php-component/' . $row->component, 'Lc5', false)){
					if (isset($row->dynamic_component)) {
						if (isset($row->dynamic_component->before_func) && trim($row->dynamic_component->before_func)) {
							if (function_exists($row->dynamic_component->before_func)) {
								// Function in custom_frontend_helper
								$row->method_data = call_user_func($row->dynamic_component->before_func, $row); //, $this->req
							} elseif (method_exists($this, $row->dynamic_component->before_func)) {
								// Method in controller web
								$row->method_data = $this->{$row->dynamic_component->before_func}($row);
							}else{
								throw \CodeIgniter\Exceptions\FrameworkException::forInvalidFile('Method not found - ' . $row->dynamic_component->before_func . ' check custom_frontend_helper and Web Controllers');
							}
						}
					}
					$row->view = $viewFilePath;
				} else {
					$row->view = customOrDefaultViewFragment('rows/php-component/empty');
				}
			}
		}
		return $processedRow;
	}

	//--------------------------------------------------------------------
	protected function getPostArchive(&$curr_entity)
	{
		// 
		if ($curr_entity->is_posts_archive) {

			// 
			$cur_post_cat_obj = null;
			$__curr_p_cat_guid = $this->req->getGet('p-cat') ?: null;
			$cur_post_tag_obj = null;
			$__curr_p_tag_guid = $this->req->getGet('p-tag') ?: null;
			// 

			$poststypes_model = new PoststypesModel();
			$poststypes_model->setForFrontemd();
			$postcat_model = new PostscategoriesModel();
			$postcat_model->setForFrontemd();
			$post_tags_model = new PostTagsModel();
			$post_tags_model->setForFrontemd();
			$posts_model = new PostsModel();
			$posts_model->setForFrontemd();
			if ($posts_archive_type = $poststypes_model->where('val', $curr_entity->is_posts_archive)->asObject()->first()) {
				// 
				$this->getPoststypesFieldsConfig($posts_archive_type);
				$orderby =  (isset($posts_archive_type->post_order) && $posts_archive_type->post_order != '') ? $posts_archive_type->post_order : 'id';
				$sortby =  (isset($posts_archive_type->post_sort) && $posts_archive_type->post_sort != '') ? $posts_archive_type->post_sort : 'DESC';
				$pagination_limit =  (isset($posts_archive_type->post_per_page) && $posts_archive_type->post_per_page != '') ? $posts_archive_type->post_per_page : __post_per_page__;
				// 
				$curr_entity->posts_archive_name = $posts_archive_type->nome;
				if ($posts_archive_type->has_archive) {
					if ($posts_archive_type->archive_root) {
						$curr_entity->posts_archive_index = site_url(__locale_uri__ . '/' . $posts_archive_type->archive_root);
					} else {
						$curr_entity->posts_archive_index = route_to(__locale_uri__ . 'web_posts_archive', $posts_archive_type->val);
					}
				} else {
					$curr_entity->posts_archive_index = null;
					$curr_entity->posts_archive_name = null;
				}
				// 
				$curr_entity->posts_castegories = $postcat_model->where('post_type', $posts_archive_type->id)->asObject()->findAll();
				if ($__curr_p_cat_guid) {
					$cur_post_cat_obj = $postcat_model->where('post_type', $posts_archive_type->id)->where('guid', $__curr_p_cat_guid)->asObject()->first();
				}
				// 
				$curr_entity->posts_tags = $post_tags_model->where('post_type', $posts_archive_type->id)->asObject()->findAll();
				if ($__curr_p_tag_guid) {
					$cur_post_tag_obj = $post_tags_model->where('post_type', $posts_archive_type->id)->where('val', $__curr_p_tag_guid)->asObject()->first();
				}
				// 

				$posts_qb = $posts_model->where('post_type', $posts_archive_type->id);
				if ($cur_post_cat_obj) {
					$posts_qb->where('category', $cur_post_cat_obj->id);
				}
				if ($cur_post_tag_obj) {
					$posts_qb->like('tags', '"' . $cur_post_tag_obj->id . '"', 'both');
				}

				if ($posts_archive = $posts_qb->asObject()->orderby('ordine', $sortby)->orderby($orderby, $sortby)->orderby('id', $sortby)->paginate($pagination_limit)) {
					foreach ($posts_archive as $post) {
						$post->abstract = word_limiter(strip_tags($post->testo), 20);
						$post->permalink = route_to(__locale_uri__ . 'web_posts_single', $posts_archive_type->val, $post->guid);
						// 
						if (env('custom.has_entity_rows_in_archive') === TRUE) {
							$post->entity_rows = $this->getEntityRows($post->id, 'posts');
						}
						// 
						$custom_parameters = null;
						if (isset($post->entity_free_values_object) && is_array($post->entity_free_values_object) && count($post->entity_free_values_object) > 0) {
							$custom_parameters = new \stdClass();
							foreach ($post->entity_free_values_object as $free_val) {
								$post->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
								$custom_parameters->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
							}
						}
						$post->entity_custom_parameters = $custom_parameters;
					}
					$curr_entity->posts_archive = $posts_archive;
				}
				$curr_entity->pager =  $posts_qb->pager;
			}
		}
	}

	//--------------------------------------------------------------------
	protected function getPoststypesFieldsConfig(&$curr_entity)
	{
		// 
		$curr_entity->post_attributes = [];
		// 
		if ($entity_fields_conf = json_decode($curr_entity->fields_config)->fields) {
			foreach ($entity_fields_conf as $post_attr) {
				$curr_entity->post_attributes[$post_attr] = true;
			}
		}
		// 
	}


	//--------------------------------------------------------------------
	protected function inviaEmail($toAddress, $mailSubject,  $htmlbody)
	{

		if (env('custom.email.protocol') == 'mailgun_api') {
			return $this->inviaEmailMailGunApi($toAddress, $mailSubject,  $htmlbody);
		} elseif (env('custom.email.protocol') == 'smtp') {
			return $this->inviaEmailSMTP($toAddress, $mailSubject,  $htmlbody);
		}
	}


	//--------------------------------------------------------------------
	protected function inviaEmailMailGunApi($toAddress, $mailSubject,  $htmlbody)
	{
		if (!env('custom.email.MailGunSigningKey') || !env('custom.email.MailGunDomain')) {
			return FALSE;
		}
		if (class_exists('\Mailgun\Mailgun')) {
			$mg = \Mailgun\Mailgun::create(env('custom.email.MailGunSigningKey'), 'https://api.eu.mailgun.net'); // For EU servers
			$mailGun_message = $mg->messages()->send(env('custom.email.MailGunDomain'), [
				'from'    => env('custom.from_address'), //env('custom.from_name')
				'to'      => $toAddress,
				'subject' => $mailSubject,
				'html'    =>  $htmlbody,
				'text'    => 'Questa email è stata inviata in formato HTML. Visualizzi questo messaggio perché il tuo client di posta non supporta queste funzionalità.',

			]);
			return $mailGun_message;
		}
		return FALSE;

		// return $this->inviaEmailSMTP($toAddress, $mailSubject,  $htmlbody);
	}


	//--------------------------------------------------------------------
	protected function inviaEmailSMTP($toAddress, $mailSubject,  $htmlbody)
	{
		$filePath = ROOTPATH . 'Lc5/Web/ThirdParty/PHPMailer/language/';
		$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
		$mail->setLanguage('it', $filePath);
		try {
			//Server settings
			// $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
			$mail->isSMTP();
			$mail->Host       = $this->send_mail_config['SMTPHost'];
			$mail->SMTPAuth   = true;
			$mail->Username   = $this->send_mail_config['SMTPUser'];
			$mail->Password   = $this->send_mail_config['SMTPPass'];
			$mail->SMTPSecure = 'tls'; // \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = $this->send_mail_config['SMTPPort'];

			//Recipients
			$mail->setFrom(env('custom.from_address'), env('custom.from_name'));
			$mail->addAddress($toAddress);

			//Content
			$mail->isHTML(true);
			$mail->Subject = $mailSubject;
			$mail->Body    = $htmlbody;
			$mail->AltBody = 'Questa email è stata inviata in formato HTML. Visualizzi questo messaggio perché il tuo client di posta non supporta queste funzionalità.';

			$mail->send();
			return true;
		} catch (\PHPMailer\PHPMailer\Exception $e) {
			// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			return false;
		}
		return FALSE;
	}

	//--------------------------------------------------------------------
	private function getEnvEmailConfig()
	{
		if (env('custom.email.protocol') == 'mailgun_api') {
			return [];
		} elseif (env('custom.email.protocol') == 'smtp') {
			return [
				'mailType' => 'html',
				'SMTPHost' => env('custom.email.SMTPHost'),
				'SMTPPort' => env('custom.email.SMTPPort'), //  465,//
				'protocol' => env('custom.email.protocol'),
				'SMTPUser' => env('custom.email.SMTPUser'),
				'SMTPPass' => env('custom.email.SMTPPass'),
				// 'SMTPCrypto' => 'tls',
				// 'SMTPAuth' => true,
				// 'SMTPKeepAlive' => true,
				// 'mailPath' => '/var/qmail/mailnames',
			];
		}


		return FALSE;
	}

	//--------------------------------------------------------------------
	protected function appLabelMethod($label, $labels, $force_return = true)
	{
		// isset($app->app_labels)
		$label_key = url_title(trim($label), '_', TRUE);
		if (isset($label_key) && trim($label_key) && isset($labels) && is_array($labels) && isset($labels[$label_key])) {
			return $labels[$label_key];
		} else if (isset($label) && trim($label) && $force_return) {
			return $label;
		}
		return '';
	}
}
