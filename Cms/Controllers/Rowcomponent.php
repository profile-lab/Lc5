<?php

namespace Lc5\Cms\Controllers;


use Lc5\Data\Models\RowcomponentsModel;

use Lc5\Data\Entities\Rowcomponent as RowcomponentEntity;

class Rowcomponent extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Componenti dinamici';
		$this->route_prefix = 'lc_tools_rows_componet';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'rowcomponent');
		
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$rows_component_model = new RowcomponentsModel();
		// 
		$list = $rows_component_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\rows-php/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$rows_component_model = new RowcomponentsModel();
		$curr_entity = new RowcomponentEntity();
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->id_app = 1;
				$rows_component_model->save($curr_entity);
				// 
				$new_id = $rows_component_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\rows-php/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$rows_component_model = new RowcomponentsModel();
		if (!$curr_entity = $rows_component_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$rows_component_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix, [$curr_entity->id]);

	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$rows_component_model = new RowcomponentsModel();
		if (!$curr_entity = $rows_component_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			// 
			if ($this->validate($validate_rules)) {
				$rows_component_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\rows-php/scheda', $this->lc_ui_date->toArray());
	}
}
