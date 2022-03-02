<?php

namespace Lc5\Cms\Controllers;

class Dashboard extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
        parent::__construct();
	}

	//--------------------------------------------------------------------
	public function index()
	{
		return view('Lc5\Cms\Views\dashboard', $this->lc_ui_date->toArray());
	}
}
