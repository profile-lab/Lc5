<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PagestypeModel;

use Lc5\Data\Entities\Pagestype as PagestypeEntity;


class Pagestype extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Tipologie pagine';
		$this->route_prefix = 'lc_tools_pagetypes';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'pagestype');
		
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$pagestype_model = new PagestypeModel();
		// 
		$list = $pagestype_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\tipologie-contenuti/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$pagestype_model = new PagestypeModel();
		$curr_entity = new PagestypeEntity();
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				if ($curr_lc_app = session()->get('curr_lc_app')) {
                    $curr_entity->id_app = $curr_lc_app;
                }
				if ($curr_entity->hasChanged()) { 
					$pagestype_model->save( $curr_entity );
				}
				// 
				$new_id = $pagestype_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\tipologie-contenuti/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$pagestype_model = new PagestypeModel();
		if (!$curr_entity = $pagestype_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			// 
			if ($this->validate($validate_rules)) {
				if ($curr_entity->hasChanged()) { 
					$pagestype_model->save( $curr_entity );
				}
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\tipologie-contenuti/scheda', $this->lc_ui_date->toArray());
	}
}
