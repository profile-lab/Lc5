<?php

namespace Lc5\Cms\Controllers;
use Lc5\Data\Models\LanguagesModel;
use Lc5\Data\Entities\Language as Entity;



class Language extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Lingue';
		$this->route_prefix = 'lc_languages';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'language');
		
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$languages_model = new LanguagesModel();
		// 
		$list = $languages_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\tipologie-contenuti/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$languages_model = new LanguagesModel();
		$curr_entity = new Entity();
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->id_app = $this->getCurrApp();
				// dd($curr_entity);
				if ($curr_entity->hasChanged()) { 
					$languages_model->save( $curr_entity );
				}
				// 
				$new_id = $languages_model->getInsertID();
				// 
				$new_entity = $languages_model->find($new_id);
				$this->createBeseAppSettings(null, $new_entity->val);
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
		$languages_model = new LanguagesModel();
		if (!$curr_entity = $languages_model->find($id)) {
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
					$languages_model->save( $curr_entity );
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
