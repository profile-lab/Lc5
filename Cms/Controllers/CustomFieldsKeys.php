<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\CustomFieldsKeysModel;

use Lc5\Data\Entities\CustomFieldsKey as CustomFieldsKeyEntity;


class CustomFieldsKeys extends MasterLc
{
	private $rows_attributes = [];
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Chiavi campi custom';
		$this->route_prefix = 'lc_tools_custom_fields_keys';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'customfieldskeys');
		// 
		$this->lc_ui_date->__set('entity_targets', $this->entity_custom_fileds_targets );
		// 
		$this->lc_ui_date->__set('entity_types', [
			"string" => (object) [ "nome" => "String", "val" => "string" ], 
			"text" => (object) [ "nome" => "Testo", "val" => "text" ], 
			"html-editor" => (object) [ "nome" => "Editor", "val" => "html-editor" ], 
			"bool" => (object) [ "nome" => "Bool", "val" => "bool" ], 
		] );
		// 
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$custom_fields_key_model = new CustomFieldsKeysModel();
		// 
		$list = $custom_fields_key_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\custom-fields-keys/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$custom_fields_key_model = new CustomFieldsKeysModel();
		$curr_entity = new CustomFieldsKeyEntity();
		// 
		if ($this->req->getPost()) {
			
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'val' => ['label' => 'Valore', 'rules' => 'required'],
			];
            // dd($this->req->getPost());
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->id_app = 1;
				$custom_fields_key_model->save($curr_entity);
				// 
				$new_id = $custom_fields_key_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		//  
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\custom-fields-keys/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$custom_fields_key_model = new CustomFieldsKeysModel();
		if (!$curr_entity = $custom_fields_key_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$custom_fields_key_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix, [$curr_entity->id]);

	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$custom_fields_key_model = new CustomFieldsKeysModel();
		if (!$curr_entity = $custom_fields_key_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'val' => ['label' => 'Valore', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			// 
			if ($this->validate($validate_rules)) {
				$custom_fields_key_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\custom-fields-keys/scheda', $this->lc_ui_date->toArray());
	}
}
