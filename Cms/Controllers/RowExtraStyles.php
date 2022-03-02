<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\RowextrastyleModel;

use Lc5\Data\Entities\Rowsextrastyle as RowsextrastyleEntity;


class RowExtraStyles extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Extra Stili paragrafi';
		$this->route_prefix = 'lc_tools_rows_extra_styles';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'rowextrastyles'); 
		
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$rows_colors_model = new RowextrastyleModel();
		// 
		$list = $rows_colors_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\tipologie-contenuti/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$rows_colors_model = new RowextrastyleModel();
		$curr_entity = new RowsextrastyleEntity();
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->id_app = 1;
				$rows_colors_model->save($curr_entity);
				// 
				$new_id = $rows_colors_model->getInsertID();
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
		$rows_colors_model = new RowextrastyleModel();
		if (!$curr_entity = $rows_colors_model->find($id)) {
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
				$rows_colors_model->save($curr_entity);
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
