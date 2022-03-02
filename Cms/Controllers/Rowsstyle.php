<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\RowsstyleModel;

use Lc5\Data\Entities\Rowsstyle as RowsstyleEntity;


class Rowsstyle extends MasterLc
{
	private $rows_attributes = [];
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Tipologie paragrafi';
		$this->route_prefix = 'lc_tools_rows_styles';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'rowsstyle');
		// 
		$this->lc_ui_date->__set('entities_types', [
			"simple" => (object) [ "nome" => "Paragrafo", "val" => "simple" ], 
			"gallery" => (object) [ "nome" => "Gallery", "val" => "gallery" ],
			"columns" => (object) [ "nome" => "Colonne", "val" => "columns" ], 
		] );
		// 
		$poststype_entity = new RowsstyleEntity();
		// $this->post_fix_attrs = $poststype_entity->post_fix_attrs;
		$this->rows_attributes = $poststype_entity->rows_attributes;
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$rows_style_model = new RowsstyleModel();
		// 
		$list = $rows_style_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\rows-styles/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$rows_style_model = new RowsstyleModel();
		$curr_entity = new RowsstyleEntity();
		// 
		$post_type_rows_attributes = [];
		foreach ($this->rows_attributes as $post_attr) {		
			$post_attr['active'] = false;
			$post_type_rows_attributes[] = $post_attr;
		}
		// 
		if ($this->req->getMethod() == 'post') {
			$post_type_rows_attributes = [];
			$field_settings = [];
			foreach ($this->rows_attributes as $post_attr) {
				if ($this->req->getPost($post_attr['name'])) {
					$post_attr['active'] = true;
					$post_type_rows_attributes[] = $post_attr;
					// 
					$field_settings[] = $post_attr['name'];
					// 
				} else {
					$post_attr['active'] = false;
					$post_type_rows_attributes[] = $post_attr;
				}
			}
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'val' => ['label' => 'Valore', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			$curr_entity->fields_config = json_encode((object) ['fields' => $field_settings]);
			if ($this->validate($validate_rules)) {
				$curr_entity->id_app = 1;
				$rows_style_model->save($curr_entity);
				// 
				$new_id = $rows_style_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->__set('rows_attributes', $post_type_rows_attributes);
		//  
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\rows-styles/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$rows_style_model = new RowsstyleModel();
		if (!$curr_entity = $rows_style_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$rows_style_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix, [$curr_entity->id]);

	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$rows_style_model = new RowsstyleModel();
		if (!$curr_entity = $rows_style_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		// 
		$entity_fields_conf = [];
		$entity_fields_conf_byjson = json_decode($curr_entity->fields_config);
		if(json_last_error() === JSON_ERROR_NONE) {
			$entity_fields_conf = $entity_fields_conf_byjson->fields;
		}
		$post_type_rows_attributes = [];
		foreach ($this->rows_attributes as $post_attr) {
			if (in_array($post_attr['name'], $entity_fields_conf)) {
				$post_attr['active'] = true;
				$post_type_rows_attributes[] = $post_attr;
			} else {
				$post_attr['active'] = false;
				$post_type_rows_attributes[] = $post_attr;
			}
		}
		// 
		if ($this->req->getMethod() == 'post') {
			$post_type_rows_attributes = [];
			$field_settings = [];
			foreach ($this->rows_attributes as $post_attr) {
				if ($this->req->getPost($post_attr['name'])) {
					$post_attr['active'] = true;
					$post_type_rows_attributes[] = $post_attr;
					// 
					$field_settings[] = $post_attr['name'];
					// 
				} else {
					$post_attr['active'] = false;
					$post_type_rows_attributes[] = $post_attr;
				}
			}
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'val' => ['label' => 'Valore', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			$curr_entity->fields_config = json_encode((object) ['fields' => $field_settings]);
			// 
			if ($this->validate($validate_rules)) {
				$rows_style_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->__set('rows_attributes', $post_type_rows_attributes);
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\rows-styles/scheda', $this->lc_ui_date->toArray());
	}
}
