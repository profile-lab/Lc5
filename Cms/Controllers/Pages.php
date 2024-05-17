<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\RowsModel;
use Lc5\Data\Models\PagestypeModel;
use Lc5\Data\Models\PoststypesModel;

use Lc5\Data\Entities\Page;


class Pages extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		// Versione base v1.1.1
		$this->module_name = 'Pagine';
		$this->route_prefix = 'lc_pages';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		// 
		$poststypes_model = new PoststypesModel();
		// 
		$poststypes = $poststypes_model->findAll();
		$this->lc_ui_date->__set('poststypes', $poststypes);
		// 
	}

	//--------------------------------------------------------------------
	public function index()
	{
		$pagestype_model = new PagestypeModel();
		// 
		$pagestypes = [];
		$__pagestypes = $pagestype_model->findAll();
		foreach ($__pagestypes as $ptype) {
			$pagestypes[$ptype->val] = $ptype;
		}
		$this->lc_ui_date->__set('pagestypes', $pagestypes);

		// 
		// $pages_model = new PagesModel();
		// 
		// $list = $pages_model->findAll();
		$list = $this->pageListByLevel();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\pages/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$pages_model = new PagesModel();
		$curr_entity = new Page();
		// 
		// $this->lc_ui_date->parents = $this->getListParents($curr_entity->id);
		$this->lc_ui_date->parents = $this->pageListByLevel(0, '', $curr_entity->id);
		$this->lc_ui_date->pages_types = $this->getModuleTypes();
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				// 'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->nome = $curr_entity->titolo;
				$curr_entity->status = 0;
				$curr_entity->public = 0;
				if ($curr_entity->hasChanged()) { 
					$pages_model->save( $curr_entity );
				}
				// 
				$new_id = $pages_model->getInsertID();
				// 
				$this->editEntityRows($new_id, 'pages');
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$errMess = $this->lc_parseValidator($this->validator->getErrors());
			}
			if ($is_falied) {
				$this->lc_ui_date->ui_mess =  ((isset($errMess)) ? $errMess : 'Utente non trovato! Controlla i dati inseriti!');
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\pages/new', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$pages_model = new PagesModel();
		if (!$curr_entity = $pages_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		// $this->lc_ui_date->parents = $this->getListParents($curr_entity->id);
		$this->lc_ui_date->parents = $this->pageListByLevel(0, '', $curr_entity->id);
		$this->lc_ui_date->pages_types = $this->getModuleTypes();
		// $this->lc_ui_date->rows_styles = $this->getRowStyles();
		$this->lc_ui_date->rows_simple_styles = $this->getRowStyles('simple');
		$this->lc_ui_date->rows_gallery_styles = $this->getRowStyles('gallery');
		$this->lc_ui_date->rows_colonne_styles = $this->getRowStyles('columns');
		$this->lc_ui_date->rows_colors = $this->getRowColors();
		$this->lc_ui_date->rows_extra_styles = $this->getRowExtraStyles();
		$this->lc_ui_date->images_formats = $this->getImgFormatiSelect();
		$this->lc_ui_date->rows_components = $this->getRowComponents();
		$this->lc_ui_date->entity_rows = $this->getEntityRows($curr_entity->id, 'pages');
		if($app_domain = $this->getAppDataField('domain')){
			$this->lc_ui_date->frontend_guid = reduce_double_slashes($app_domain .'/' . (($this->curr_lc_lang != $this->default_lc_lang) ? $this->curr_lc_lang.'/' : '')  . $curr_entity->guid);
		}
		// 
		if ($curr_entity->created_at == $curr_entity->updated_at) {
			$curr_entity->public = 1;
		}
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				// 'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			// 
			if ($this->validate($validate_rules)) {
				// 
				if ($curr_entity->created_at == $curr_entity->updated_at) {
					$curr_entity->status = 1;
				}
				// $curr_entity->public = $this->req->getPost('public') ? 1 : 0 ;
				if($this->req->getPost('public')){
					$curr_entity->status = 1;
					$curr_entity->public = 1;
				}else{
					$curr_entity->public = 0;
				}
				// 
				if ($curr_entity->hasChanged()) { 
					$pages_model->save( $curr_entity );
				}
				// 
				$this->editEntityRows($curr_entity->id, 'pages');
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$errMess = $this->lc_parseValidator($this->validator->getErrors());
			}
			if ($is_falied) {
				$this->lc_ui_date->ui_mess =  ((isset($errMess)) ? $errMess : 'Utente non trovato! Controlla i dati inseriti!');
				$this->lc_ui_date->ui_mess_type = 'danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\pages/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	private function getModuleTypes()
	{
		$pagestype_model = new PagestypeModel();
		return $pagestype_model->findAll();
	}

	//--------------------------------------------------------------------
	public function setAsHome($id)
	{
		// 
		$pages_model = new PagesModel();
		if (!$curr_entity = $pages_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$list = $pages_model->where('parent', 0)->findAll();
		foreach ($list as $up_data) {
			$up_data->is_home = 0;
			$pages_model->save($up_data);
		}
		$curr_entity->is_home = 1;
		if ($curr_entity->hasChanged()) { 
			$pages_model->save( $curr_entity );
		}
		return redirect()->route($this->route_prefix);
	}

	//--------------------------------------------------------------------
	public function duplicate($id, $lang = null)
	{
		// 
		$pages_model = new PagesModel();
		$rows_model = new RowsModel();
		if (!$current_base_entity = $pages_model->allowCallbacks(FALSE)->asArray()->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		//

		$current_base_entity['id'] = null;
		$current_base_entity['parent'] = 0;
		$current_base_entity['nome'] .= '-copy';
		$current_base_entity['guid'] .= '-copy';
		if ($lang) {
			$current_base_entity['lang'] = $lang;
			$current_base_entity['nome'] .= '-' . $lang;
			$current_base_entity['guid'] .= '-' . $lang;
		}
		// dd($current_base_entity);
		if ($pages_model->insert($current_base_entity)) {
			$new_id = $pages_model->getInsertID();
			// 
			$current_base_entity_rows = $rows_model
				->allowCallbacks(FALSE)
				->asArray()
				->orderBy('ordine', 'ASC')
				->where('parent', $id)
				->where('modulo', 'pages')
			->findAll();
			if ($current_base_entity_rows) {
				foreach ($current_base_entity_rows as $old_entity_row) {
					$old_entity_row['id'] = null;
					$old_entity_row['parent'] = $new_id;
					if ($lang) {
						$old_entity_row['lang'] = $lang;
					}
					$rows_model->save($old_entity_row);
				}
			}
		}
		$this->lc_setErrorMess('Contenuto duplicato con successo', 'alert-success');
		return redirect()->route($this->route_prefix);
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$pages_model = new PagesModel();
		$rows_model = new RowsModel();
		if (!$curr_entity = $pages_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		if ($entity_rows = $this->getEntityRows($curr_entity->id, 'pages')) {
			foreach ($entity_rows as $entity_row) {
				$rows_model->delete($entity_row->id);
			}
		}

		$pages_model->delete($curr_entity->id);
		$this->lc_setErrorMess('Contenuto eliminato con successo', 'alert-warning');

		return redirect()->route($this->route_prefix);
	}

	//--------------------------------------------------------------------
	private function getListParents($exclude_id = null)
	{
		// 
		$pages_model = new PagesModel();
		// 
		$list_qb = $pages_model->select('id as val, nome')->asObject();
		if ($exclude_id) {
			$list_qb->where('id !=', $exclude_id);
		}
		return $list_qb->findAll();
	}
}
