<?php
namespace Lc5\Api\Controllers;

use CodeIgniter\API\ResponseTrait;


class ApiServices extends \App\Controllers\BaseController
{
    
	use ResponseTrait;


    //--------------------------------------------------------------------
    public function __construct()
    {
      
    }

    //--------------------------------------------------------------------
	public function respond ($data, $statusCode = 200, $message = 'Not Found')
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
	public function exitUnauthorized()
	{
		$response = [
			'status' => 401,
			'error' => 'Unauthorized',
			'message' => 'Unauthorized'
		];
		return $this->respond($response, 401, 'Unauthorized');
	}
	//--------------------------------------------------------------------
	public function responseDebug($message)
	{

		// $response = [
		// 	'status' => 200,
		// 	'message' => $message
		// ];
		// return $this->respond($response, 200, 'Message: '. $message);
		$returnObject = (object)[
			'status' => 200,
			'body' => 'Message: '. $message
		];
		return $this->respond($returnObject);
		exit;
	}

}
