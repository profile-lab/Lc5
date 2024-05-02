<?php

namespace Lc5\Api\Controllers;

use CodeIgniter\API\ResponseTrait;
use Lc5\Web\Controllers\MasterApp;
use stdClass;

class MasterApi extends MasterApp
{
	
	use ResponseTrait;

	protected $apiservices = null;
	protected $rest_data = null;
	//--------------------------------------------------------------------
	public function __construct()
	{
		
		parent::__construct();

		$this->rest_data = new stdClass();
		$this->apiservices = \Config\Services::apiservices();


		//
		// 
		// $this->web_ui_date = new WebUiData();



		// if($this->form_result){
		// 	// form_result is set in MasterApp class
		// 	$this->web_ui_date->__set('form_result', $this->form_result);
		// 	if (isset($this->form_result) && isset($this->form_result->is_send) && $this->form_result->is_send === TRUE) {
		// 		return redirect()->to(uri_string() . '?is_send=true');
		// 	}
		// }
		// $this->web_ui_date->__set('form_post_data', $this->form_post_data);
	}

	//--------------------------------------------------------------------
	public function sendResponse ($data, $statusCode = 200, $message = 'Not Found')
	{
		$response = [
			'status' => $statusCode,
			'error' => null,
			'message' => $message,
            'data' => $data
		];
		return $this->respond($response, $statusCode);
	}

	//--------------------------------------------------------------------
	public function exitNotFound ()
	{
		$response = [
			'status' => 404,
			'error' => 'Not Found',
			'message' => 'Not Found'
		];
		return $this->respond($response, 404, 'Not Found');
	}

	//--------------------------------------------------------------------
	protected function exitUnauthorized()
	{
		header("HTTP/1.1 401 Unauthorized");
		$response = [
			'status' => 401,
			'error' => 'Unauthorized',
			'message' => 'Unauthorized'
		];
		return json_encode($response);
		// return $this->respond($response, 401, 'Unauthorized');
	}
	
}
