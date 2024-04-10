<?php

namespace Lc5\Web\Controllers;


class DesignSystem extends MasterWeb
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->web_ui_date->__set('request', $this->req);
		// 
	}

	//--------------------------------------------------------------------
	public function list()
	{
		//
		if (appIsFile($this->base_view_filesystem . 'design-system.php')) {
			return view($this->base_view_namespace . 'design-system');
		} else {
			$this->base_view_namespace = $this->lc5_views_namespace;
			return view($this->base_view_namespace.'design-system');
		}
	}

	
}
