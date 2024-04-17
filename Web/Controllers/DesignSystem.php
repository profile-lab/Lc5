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
		return view(customOrDefaultViewFragment('design-system'), $this->web_ui_date->toArray());
	}
	//--------------------------------------------------------------------
	public function grid()
	{
		return view(customOrDefaultViewFragment('design-system-grid'), $this->web_ui_date->toArray());
	}

	
}
