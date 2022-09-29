<?php

namespace Lc5\Web\Controllers\Users;

use Lc5\Web\Controllers\MasterWeb;

// use Lc5\Data\Models\PagesModel;

class UserMaster extends MasterWeb
{
    protected $req;
    
    
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
		// 
		// $this->web_ui_date->__set('request', $this->req);
		// 
        // $this->req = \Config\Services::request();
    }

    
	//--------------------------------------------------------------------
	protected function sendAccountVerificationEmail($to_address, $email_subject, $htmlbody)
	{	
		if($this->send_mail_config){
			if($this->send_mail_config['protocol'] == 'smtp'){
				return $this->inviaEmailSMTP($to_address, $email_subject,  $htmlbody);
			}
		}
		// $credentials = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', env('custom.sendinblue_api_key'));
		// $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(new \GuzzleHttp\Client(), $credentials);


	


		// $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
		// 	'subject' => $email_subject,
		// 	'sender' => ['name' => $from_name, 'email' => $from_address],
		// 	'replyTo' => ['name' => 'Prime Tutor', 'email' => 'info@primetutor.it'],
		// 	'to' => [['name' => $to_name , 'email' => $to_address]],
		// 	'htmlContent' => $htmlbody,
		// 	'params' => $body_params
		// ]);

		// try {
		// 	return $apiInstance->sendTransacEmail($sendSmtpEmail);
		// } catch (\Exception $e) {
		// 	return false;
		// 	// session()->setFlashdata('ui_mess', 'Si è verificato un errore durante l\'invio della mail di verifica');
		// 	// session()->setFlashdata('ui_mess_type', 'alert alert-danger');
		// }

        return FALSE;

	}
	//--------------------------------------------------------------------
	protected function sendToUserEmail($to_address, $to_name, $from_address, $from_name, $email_subject, $htmlbody, $body_params= null)
	{	
		// $credentials = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', env('custom.sendinblue_api_key'));
		// $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(new \GuzzleHttp\Client(), $credentials);


	


		// $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
		// 	'subject' => $email_subject,
		// 	'sender' => ['name' => $from_name, 'email' => $from_address],
		// 	'replyTo' => ['name' => 'Prime Tutor', 'email' => 'info@primetutor.it'],
		// 	'to' => [['name' => $to_name , 'email' => $to_address]],
		// 	'htmlContent' => $htmlbody,
		// 	'params' => $body_params
		// ]);

		// try {
		// 	return $apiInstance->sendTransacEmail($sendSmtpEmail);
		// } catch (\Exception $e) {
		// 	return false;
		// 	// session()->setFlashdata('ui_mess', 'Si è verificato un errore durante l\'invio della mail di verifica');
		// 	// session()->setFlashdata('ui_mess_type', 'alert alert-danger');
		// }

        return TRUE;

	}


	// //--------------------------------------------------------------------
    // protected function sendSubscriptionEmail($__user)
    // {   
	// 	// // $email_user_data = (object)[
	// 	// // 	'name' => $ddd,
	// 	// // 	'surname' => $ddd,
	// 	// // 	'email' => $ddd,
	// 	// // ];
	// 	// // 
	// 	// $body_params = [
	// 	// 	'name' => $__user->name,
	// 	// 	'surname' => $__user->surname,
	// 	// 	'email' => $__user->email,
	// 	// 	'logo_path' => site_url('/assets/img/primetutor-bianco.png'),
	// 	// ];
	// 	// $htmlbody = file_get_contents(APPPATH . 'Views/email/sottoscrizione_attivata.html');
	// 	// $email_subject = 'Prime Tutor - Abbonamento attivo';
	// 	// $this->sendInBlueEmail($__user->email, $__user->name . ' ' . $__user->surname, $this->from_address, $this->from_name, $email_subject, $htmlbody, $body_params);
			 
    //     return TRUE;
	// }

}
