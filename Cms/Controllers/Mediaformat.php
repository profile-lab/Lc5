<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\MediaformatModel;

use Lc5\Data\Entities\Mediaformat as MediaformatEntity;


class Mediaformat extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Formati Media';
		$this->route_prefix = 'lc_media_formati';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		$this->lc_ui_date->__set('currernt_module', 'media');
		$this->lc_ui_date->__set('currernt_module_action', 'mediaformat');
		// 
		$this->lc_ui_date->__set('rules', [
			(object) ['val' => 'crop', 'nome' => 'Crop'],
			(object) ['val' => 'fit', 'nome' => 'Fit'],
			(object) ['val' => 'scale', 'nome' => 'Scale'],
			(object) ['val' => '', 'nome' => 'Web'],
			(object) ['val' => 'in', 'nome' => 'Adatta in (nero)'],
		]);
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$mediaformat_model = new MediaformatModel();
		// 
		$list = $mediaformat_model->findAll();
		$this->lc_ui_date->list = $list;
		$this->lc_ui_date->static_format_list = [];
		$media_formats_config = $this->getProjectSettingsValue('media_formats');
		if ($media_formats_config) {
			$new_static_format_list = [];
			foreach ($media_formats_config as $current_media_format) {
				$new_static_format_list[] = (object) $current_media_format;
			}
			$this->lc_ui_date->static_format_list = $new_static_format_list;
		}

		// 
		return view('Lc5\Cms\Views\media-formati/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$mediaformat_model = new MediaformatModel();
		$curr_entity = new MediaformatEntity();
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				// $curr_entity->id_app = 1;
				if ($curr_entity->hasChanged()) {
					$mediaformat_model->save($curr_entity);
				}
				// 
				$new_id = $mediaformat_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\media-formati/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$mediaformat_model = new MediaformatModel();
		if (!$curr_entity = $mediaformat_model->find($id)) {
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
					$mediaformat_model->save($curr_entity);
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
		return view('Lc5\Cms\Views\media-formati/scheda', $this->lc_ui_date->toArray());
	}
}
