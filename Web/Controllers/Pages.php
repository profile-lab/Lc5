<?php

namespace Lc5\Web\Controllers;

use Config\Services;
use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\PostsModel;
use Lc5\Data\Models\PoststypesModel;

class Pages extends MasterWeb
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->web_ui_date->__set('request', $this->req);
		// 
	}

	//--------------------------------------------------------------------
	public function index()
	{
		return $this->page();
	}
	//--------------------------------------------------------------------
	public function addMaintainer()
	{
		$data = [
			'maintainer_user' => 'maintainer_' . uniqid()
		];
		session()->set($data);
		return redirect()->route('web_homepage');
		// return $this->page();
	}

	//--------------------------------------------------------------------
	public function error404($error = null)
	{
		$curr_entity = new \stdClass();
		$curr_entity->titolo = 'Errore 404';
		$curr_entity->testo = 'Pagina non trovata';
		$curr_entity->seo_title = '404 Pagina non trovata';
		$curr_entity->seo_description = '404 Pagina non trovata';

		$this->web_ui_date->fill((array)$curr_entity);
		$this->web_ui_date->__set('master_view', '404');
		$this->web_ui_date->__set('message', lang('Contenuto non trovato'));
		$this->web_ui_date->__set('error', $error);
		// 
		return view(customOrDefaultViewFragment('404'), $this->web_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function page($seg1 = false, $seg2 = false, $seg3 = false, $seg4 = false, $seg5 = false)
	{
		$guid = $this->parseGuid($seg1, $seg2, $seg3, $seg4, $seg5);
		// 
		$pages_model = new PagesModel();
		$pages_model->setForFrontemd();
		$qb = $pages_model->asObject()->orderBy('id', 'DESC');
		if ($guid) {
			$qb->where('guid', $guid);
		} else {
			$qb->where('is_home', 1);
		}
		if (!$curr_entity = $qb->first()) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		if ($curr_entity->is_posts_archive) {
			$this->getPostArchive($curr_entity);
		}
		// 
		$custom_parameters = null;
		if (isset($curr_entity->entity_free_values_object) && is_array($curr_entity->entity_free_values_object) && count($curr_entity->entity_free_values_object) > 0) {
			$custom_parameters = new \stdClass();
			foreach ($curr_entity->entity_free_values_object as $free_val) {
				$curr_entity->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
				$custom_parameters->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
			}
		}
		$curr_entity->entity_custom_parameters = $custom_parameters;
		// 
		$this->web_ui_date->fill((array)$curr_entity);
		// 
		$this->web_ui_date->entity_rows = $this->getEntityRows($curr_entity->id, 'pages');
		// 
		if (isset($this->custom_app_contoller) && $this->custom_app_contoller) {
			$custom_app_contoller_method = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[\s_]+/', ' ', str_replace(['-', '_'], ' ', $curr_entity->type)))));
			if (method_exists($this->custom_app_contoller, $custom_app_contoller_method)) {
				$this->custom_app_contoller->{$custom_app_contoller_method}($this);
			}
		}
		// 
		if (isset($this->shop_settings_data) && $this->shop_settings_data) {
			$this->web_ui_date->__set('shop_settings_data', $this->shop_settings_data);
			if (trim($this->shop_settings_data->shop_home)) {
				$shop_home_guid = trim(str_replace(['/'], '', $this->shop_settings_data->shop_home));
				if ($shop_home_guid == $curr_entity->guid) {
					$refShopClass = 'LcShop\Web\Controllers\Shop';
					if (class_exists($refShopClass)) {
						$shopClass = new $refShopClass();
						return $shopClass->index();
					}
				}
			}
		}
		// 
		if ($viewFilePath = customOrDefaultViewFragment('page-' . $curr_entity->type, 'Lc5', false)) {
			$this->web_ui_date->__set('master_view', $curr_entity->type);
			return view($viewFilePath, $this->web_ui_date->toArray());
		} else {
			$this->web_ui_date->__set('master_view', 'default');
			return view(customOrDefaultViewFragment('page-default'), $this->web_ui_date->toArray());
		}
	}

	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	// ---- TOOLS ----
	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	private function parseGuid($seg1 = false, $seg2 = false, $seg3 = false, $seg4 = false, $seg5 = false)
	{
		$__guid = null;
		if ($seg1) {
			$__guid = $seg1;
		}
		if ($seg2) {
			$__guid = $seg2;
		}
		if ($seg3) {
			$__guid = $seg3;
		}
		if ($seg4) {
			$__guid = $seg4;
		}
		if ($seg5) {
			$__guid = $seg5;
		}
		return $__guid;
	}
}
