<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\MenusModel;
use Lc5\Data\Models\PagesModel;

use Lc5\Data\Entities\MenuItem;


class Sitemenus extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Menu';
		$this->route_prefix = 'lc_menus';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// $this->lc_ui_date->__set('entities_types', ["simple" => (object) [ "nome" => "Paragrafo", "val" => "simple" ], "gallery" => (object) [ "nome" => "Gallery", "val" => "gallery" ] ] );
		// 
		
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$menus_model = new MenusModel();
		// 
		$list = $menus_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\site-menu/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$menus_model = new MenusModel();
		$curr_entity = new MenuItem();
		// 
		$all_page_list = $this->pageListByLevel();
		$this->lc_ui_date->all_page_list = $all_page_list;
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->id_app = 1;
				$menus_model->save($curr_entity);
				// 
				$new_id = $menus_model->getInsertID();
				// 
				return redirect()->route($this->route_prefix . '_edit', [$new_id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\site-menu/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$menus_model = new MenusModel();
		if (!$curr_entity = $menus_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$menus_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix, [$curr_entity->id]);

	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$menus_model = new MenusModel();
		if (!$curr_entity = $menus_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		$all_page_list = $this->pageListByLevel();
		$this->lc_ui_date->all_page_list = $all_page_list;

		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$curr_entity->fill($this->req->getPost());
			// 
			if ($this->validate($validate_rules)) {
				$menus_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\site-menu/scheda', $this->lc_ui_date->toArray());
	}
}
