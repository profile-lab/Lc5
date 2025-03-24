<?php

namespace Lc5\Web\Controllers;

use Lc5\Data\Entities\WebUiData;

class MasterWeb extends MasterApp
{
	protected $lc5_views_namespace = '\Lc5\Web\Views/';
	protected $base_view_namespace = null;
	protected $base_view_filesystem = null;

	protected $base_assets_folder = 'assets/web/';
	public $web_ui_date;
	//--------------------------------------------------------------------
	public function __construct()
	{
		
		parent::__construct();
		//
		$this->base_view_namespace = $this->lc5_views_namespace . (getenv('custom.web_base_folder')) ?  getenv('custom.web_base_folder') . '/' : '';
		$this->base_view_filesystem =  'Views' . DIRECTORY_SEPARATOR . ((getenv('custom.web_base_folder')) ?  getenv('custom.web_base_folder') . '/' : '');
		$this->base_assets_folder = (getenv('custom.base_assets_folder')) ?  getenv('custom.base_assets_folder') . '/' : '/assets/';
		// 
		if(!defined('__base_assets_folder__')){
			define('__base_assets_folder__', $this->base_assets_folder);
		}
		// 
		$this->web_ui_date = new WebUiData($this->currentapp);
		$asset_version = $this->getAppProjectSettingsValue('asset_version');
		if($asset_version){
			$this->web_ui_date->__set('asset_version', $asset_version);
		}


		if ($maintenance_view = $this->checkIsInMaintenance()) {			
			exit($maintenance_view);
		}

		$this->web_ui_date->__set('base_view_folder', $this->base_view_namespace);

		if($this->form_result){
			// form_result is set in MasterApp class
			$this->web_ui_date->__set('form_result', $this->form_result);
			if (isset($this->form_result) && isset($this->form_result->is_send) && $this->form_result->is_send === TRUE) {
				return redirect()->to(uri_string() . '?is_send=true');
			}
		}
		$this->web_ui_date->__set('form_post_data', $this->form_post_data);
	}

	//--------------------------------------------------------------------
	protected function checkIsInMaintenance()
	{
		// 
		$is_in_maintenance = FALSE;
		if (((ENVIRONMENT != 'production' && env('custom.maintenance_mode') != 'DISABLED') || env('custom.maintenance_mode') == 'ACTIVE') || ($this->currentapp->is_in_maintenance_mode)) {
			$admins = \Config\Services::admins();
			// if ($this->req->getPath() == 'add-maintainer') {
			if(in_array($this->req->getPath(), $this->exclude_maintenance_paths)){	
				return FALSE;
			} elseif (session()->__get('maintainer_user')) {
				return FALSE;
			} elseif (!isset($admins) || !$admins->user_id()) {
				$is_in_maintenance = TRUE;
			}
		}
		// 
		if ($is_in_maintenance) {
			return view(customOrDefaultViewFragment('maintenance'), $this->web_ui_date->toArray());
		}
		return FALSE;
	}
	
}
