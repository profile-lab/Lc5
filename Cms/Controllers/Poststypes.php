<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PoststypesModel;
use Lc5\Data\Entities\Poststype;
use Lc5\Data\Entities\Post;

class Poststypes extends MasterLc
{
	// private $post_fix_attrs = [];
	private $post_attributes = [];

	// private $post_attributes = []; 
	// private $post_fix_attrs = [	
	// 	'status' => 'checkbox', 'id_app' => 'AUTO_APP', 'lang' => 'AUTO_APP', 'ordine' => 'number', 'post_type' => 'AUTO_APP', 
	// 	'nome' => 'text', 'guid' => 'readonly', 'titolo' => 'text', 'testo' => 'html-editor', 'json_data' =>  'AUTO_APP'
	// ];
	// 'public', 'is_evi',  'sottotitolo', 'testo_breve', 'testo', 'main_img_id', 'alt_img_id', 'seo_title', 'seo_description', 'seo_keyword', 'extra_field', 'custom_field', 'gallery', 'json_data', 
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Tipologie Post';
		$this->route_prefix = 'lc_tools_poststypes';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'poststypes');
		// 
		$this->lc_ui_date->__set('has_setting_select_value', [
			"0" => (object) [ "nome" => "NO", "val" => "0" ], 
			"1" => (object) [ "nome" => "YES", "val" => "1" ]
		] );
		
		$this->lc_ui_date->__set('post_ordine_keys_values', [
			"id" => (object) [ "nome" => "id", "val" => "id" ], 
			"created_at" => (object) [ "nome" => "Creazione", "val" => "created_at" ], 
			"updated_at" => (object) [ "nome" => "Aggiornamento", "val" => "updated_at" ], 
			"nome" => (object) [ "nome" => "Nome", "val" => "nome" ], 
			"titolo" => (object) [ "nome" => "Titolo", "val" => "titolo" ], 
			"data_pub" => (object) [ "nome" => "Data Pubblicazione", "val" => "data_pub" ], 
			"data_evento" => (object) [ "nome" => "Data Evento", "val" => "data_evento" ], 
			"ordine" => (object) [ "nome" => "Ordine", "val" => "ordine" ], 
		] );
		$this->lc_ui_date->__set('post_ordine_directions_values', [
			"DESC" => (object) [ "nome" => "Decrescente", "val" => "DESC" ], 
			"1" => (object) [ "nome" => "Crescente", "val" => "ASC" ]
		] );
		
		// 
		$poststype_entity = new Poststype();
		// $this->post_fix_attrs = $poststype_entity->post_fix_attrs;
		$this->post_attributes = $poststype_entity->post_attributes;

	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$poststypes_model = new PoststypesModel();
		// 
		$list = $poststypes_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\posts-types/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$poststypes_model = new PoststypesModel();
		$curr_entity = new Poststype();
		// 
		$post_type_post_attributes = [];
		foreach ($this->post_attributes as $post_attr) {
			$post_attr['active'] = false;
			$post_type_post_attributes[] = $post_attr;
		}

		// 
		if ($this->req->getMethod() == 'post') {
			$post_type_post_attributes = [];
			$field_settings = [];
			foreach ($this->post_attributes as $post_attr) {
				if ($this->req->getPost($post_attr['name'])) {
					$post_attr['active'] = true;
					$post_type_post_attributes[] = $post_attr;
					// 
					$field_settings[] = $post_attr['name'];
					// 
				} else {
					$post_attr['active'] = false;
					$post_type_post_attributes[] = $post_attr;
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
				$poststypes_model->save($curr_entity);
				// 
				$new_id = $poststypes_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->__set('post_attributes', $post_type_post_attributes);
		//  
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\posts-types/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$poststypes_model = new PoststypesModel();
		if (!$curr_entity = $poststypes_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		$entity_fields_conf = [];
		$entity_fields_conf_byjson = json_decode(($curr_entity->fields_config) ?: '' );
		if(json_last_error() === JSON_ERROR_NONE) {
			$entity_fields_conf = $entity_fields_conf_byjson->fields;
		}
		// $entity_fields_conf = json_decode($curr_entity->fields_config)->fields;
		$post_type_post_attributes = [];
		foreach ($this->post_attributes as $post_attr) {
			if (in_array($post_attr['name'], $entity_fields_conf)) {
				$post_attr['active'] = true;
				$post_type_post_attributes[] = $post_attr;
			} else {
				$post_attr['active'] = false;
				$post_type_post_attributes[] = $post_attr;
			}
		}
		// 
		if ($this->req->getMethod() == 'post') {
			$post_type_post_attributes = [];
			$field_settings = [];
			foreach ($this->post_attributes as $post_attr) {
				if ($this->req->getPost($post_attr['name'])) {
					$post_attr['active'] = true;
					$post_type_post_attributes[] = $post_attr;
					// 
					$field_settings[] = $post_attr['name'];
					// 
				} else {
					$post_attr['active'] = false;
					$post_type_post_attributes[] = $post_attr;
				}
			}
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'val' => ['label' => 'Valore', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			$curr_entity->fields_config = json_encode((object) ['fields' => $field_settings]);
			// 
			if ($this->validate($validate_rules)) {
				$poststypes_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->__set('post_attributes', $post_type_post_attributes);
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\posts-types/scheda', $this->lc_ui_date->toArray());
	}
}
