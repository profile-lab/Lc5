<?php

namespace Lc5\Cms\Controllers;
use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\LanguagesModel;
use Lc5\Data\Entities\Lcapp as Entity;


class Lcapps extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Apps';
		$this->route_prefix = 'lc_apps';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
		$this->lc_ui_date->__set('currernt_module', 'tools');
		$this->lc_ui_date->__set('currernt_module_action', 'lcapps');
		
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$lcapps_model = new LcappsModel();
		// 
		$list = $lcapps_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\apps/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$lcapps_model = new LcappsModel();
		$curr_entity = new Entity();
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$lcapps_model->save($curr_entity);
				// 
				$new_id = $lcapps_model->getInsertID();

				// dati base nuova app
				$data = [ 'new_app_created_id' => $new_id  ];
				session()->set($data);


				$seeder = \Config\Database::seeder();

				// if (!$id_app = session()->get('new_app_created_id')) { 
				// 	$id_app = 1;
				// }
				$seeder->call('\Lc5\Data\Database\Seeds\Pagestype');
				$seeder->call('\Lc5\Data\Database\Seeds\Rowsstyle');
				$seeder->call('\Lc5\Data\Database\Seeds\Mediaformats');
				$seeder->call('\Lc5\Data\Database\Seeds\Poststypes');
				$seeder->call('\Lc5\Data\Database\Seeds\Language');

				// 
				$this->createBeseAppSettings($new_id);
				// 
				
				session()->remove('new_app_created_id');
				
				// dati base nuova app
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\apps/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$lcapps_model = new LcappsModel();
		if (!$curr_entity = $lcapps_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		$app_languages = $lcapps_model->getAppLanguages($curr_entity->id );
		$this->lc_ui_date->app_languages = $app_languages;
		// 
		$curr_entity->app_labels_object = [];
		if (isset($curr_entity->labels_json_object) && trim($curr_entity->labels_json_object)) {
			$labels_object = json_decode($curr_entity->labels_json_object);
			if (json_last_error() === JSON_ERROR_NONE) {
				$app_labels_object_arr = [];
				foreach ($labels_object as $key => $values) {
					$c_lang_arr = [];
					foreach ($values as $lang_key => $lang_val) {
						$c_lang_arr[$lang_key] = $lang_val;
					}
					$app_labels_object_arr[$key] = $c_lang_arr;
				}
				$curr_entity->app_labels_object = $app_labels_object_arr;
			}
		}
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			// dd($curr_entity);
			// 
			if ($this->validate($validate_rules)) {
				$lcapps_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\apps/scheda', $this->lc_ui_date->toArray());
	}
}
