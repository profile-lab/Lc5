<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\ShopProductsCategoriesModel;
// use Lc5\Data\Models\ShopProductsModel;
use Lc5\Data\Entities\ShopProductsCategory;

class ShopProductsCategories extends MasterLc
{
	protected $current_shop_setting;
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Categorie prodotti';
		$this->route_prefix = 'lc_shop_prod_cat';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		$this->lc_ui_date->__set('currernt_module', 'shopproduct');
		$this->lc_ui_date->__set('currernt_module_action', 'shopproductscat');

		// 
		$this->current_shop_setting  = $this->getShopSettings();
		$this->lc_ui_date->__set('current_shop_setting', $this->current_shop_setting);
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$shop_product_cat_model = new ShopProductsCategoriesModel();
		// 
		$list = $shop_product_cat_model->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\shop/products-cats/index', $this->lc_ui_date->toArray());
	}
	//--------------------------------------------------------------------
	public function newpost()
	{
		$this->lc_ui_date->__set('back_to_list_btn_url', route_to($this->route_prefix));
		//  
		$shop_product_cat_model = new ShopProductsCategoriesModel();
		$curr_entity = new ShopProductsCategory();
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				// $curr_entity->id_app = 1;
				$shop_product_cat_model->save($curr_entity);
				// 
				$new_id = $shop_product_cat_model->getInsertID();
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
		return view('Lc5\Cms\Views\shop/products-cats/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		$this->lc_ui_date->__set('back_to_list_btn_url', route_to($this->route_prefix));
		// 
		$shop_product_cat_model = new ShopProductsCategoriesModel();
		if (!$curr_entity = $shop_product_cat_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}


		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				$shop_product_cat_model->save($curr_entity);
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
		return view('Lc5\Cms\Views\shop/products-cats/scheda', $this->lc_ui_date->toArray());
	}
}
