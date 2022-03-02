<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\ShopProductsColorsModel as CurrentModel;
use Lc5\Data\Entities\ShopProductsColor  as CurrentEntity;

use CodeIgniter\API\ResponseTrait;


class ShopProductsColors extends MasterLc
{
	protected $current_shop_setting;
	// private $post_attributes;

	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Varianti Prodotti';
		$this->route_prefix = 'lc_shop_prod_colors';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		$this->lc_ui_date->__set('currernt_module', 'shopproduct');
		$this->lc_ui_date->__set('currernt_module_action', 'shopsettings');
		$this->lc_ui_date->__set('currernt_module_tab', 'shopproductscolors');
		$this->lc_ui_date->__set('shop_tools_tabs', $this->getShopToolsTabs());
		// 
		$this->current_shop_setting  = $this->getShopSettings();
		$this->lc_ui_date->__set('current_shop_setting', $this->current_shop_setting);
	}





	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$shop_products_tags_model = new CurrentModel();
		// 
		$list = $shop_products_tags_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\shop/like-tags/index', $this->lc_ui_date->toArray());
	}


	//--------------------------------------------------------------------
	use ResponseTrait;
	public function ajaxCreate()
	{
		$shop_products_tags_model = new CurrentModel();
		$curr_entity = new CurrentEntity();
		// 
		if ($this->req->getMethod() == 'post') {
			$my_nome = $this->req->getPost('nome');
			$my_val = url_title(trim($my_nome), '-', TRUE);
			// 
			if ($old_entity = $shop_products_tags_model->where('val', $my_val)->first()) {
				return $this->respondCreated($old_entity);
			}
			// 
			$curr_entity->nome = $my_nome;
			$curr_entity->val = $my_val;
			$curr_entity->status = 1;
			$shop_products_tags_model->insert($curr_entity);
			$new_id = $shop_products_tags_model->getInsertID();
			if (!$new_entity = $shop_products_tags_model->find($new_id)) {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
			return $this->respondCreated($new_entity);
			// return $this->respond($new_entity);
		} else {
			return $this->failUnauthorized('Invalid Method');
		}
	}


	//--------------------------------------------------------------------
	public function newpost()
	{
		$this->lc_ui_date->__set('back_to_list_btn_url', route_to($this->route_prefix));
		//  
		$shop_products_tags_model = new CurrentModel();
		$curr_entity = new CurrentEntity();
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				if (!$this->req->getPost('val')) {
					$curr_entity->val = url_title(trim($this->req->getPost('nome')), '-', TRUE);
				}
				$shop_products_tags_model->save($curr_entity);
				// 
				$new_id = $shop_products_tags_model->getInsertID();
				// 
				// $this->editEntityRows($new_id, 'pages');
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
		return view('Lc5\Cms\Views\shop/like-tags/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		$this->lc_ui_date->__set('back_to_list_btn_url', route_to($this->route_prefix));
		// 
		$shop_products_tags_model = new CurrentModel();
		if (!$curr_entity = $shop_products_tags_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}


		// 
		// 
		// dd($this->post_attributes); 
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				if (!$this->req->getPost('val')) {
					$curr_entity->val = url_title(trim($this->req->getPost('nome')), '-', TRUE);
				}
				if ($curr_entity->hasChanged('nome') || $curr_entity->hasChanged('val')) {
					$shop_products_tags_model->save($curr_entity);
				}
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
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
		return view('Lc5\Cms\Views\shop/like-tags/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$shop_products_tags_model = new CurrentModel();
		if (!$curr_entity = $shop_products_tags_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$shop_products_tags_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix);
	}
}
