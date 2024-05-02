<?php

namespace Lc5\Api\Controllers;

use Lc5\Web\Controllers\MasterApp;
use stdClass;

class MasterApi extends MasterApp
{
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

	// //--------------------------------------------------------------------
	// protected function checkIsInMaintenance()
	// {
	// 	// 
	// 	$is_in_maintenance = FALSE;
	// 	if (((ENVIRONMENT != 'production' && env('custom.maintenance_mode') != 'DISABLED') || env('custom.maintenance_mode') == 'ACTIVE') || ($is_in_maintenance_mode = $this->web_ui_date->app->is_in_maintenance_mode)) {
	// 		$admins = \Config\Services::admins();
	// 		if ($this->req->getPath() == 'add-maintainer') {
	// 			return FALSE;
	// 		} elseif (session()->__get('maintainer_user')) {
	// 			return FALSE;
	// 		} elseif (!isset($admins) || !$admins->user_id()) {
	// 			$is_in_maintenance = TRUE;
	// 		}
	// 	}
	// 	// 
	// 	if ($is_in_maintenance) {
	// 		return view(customOrDefaultViewFragment('maintenance'), $this->web_ui_date->toArray());
	// 	}
	// 	return FALSE;
	// }
	
}
