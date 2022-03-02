<?php

namespace Lc5\Web\Controllers;

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
	public function page($seg1 = false, $seg2 = false, $seg3 = false, $seg4 = false, $seg5 = false)
	{
		$guid = $this->parseGuid($seg1, $seg2, $seg3, $seg4, $seg5);
		// 
		$pages_model = new PagesModel();
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
		if(isset($curr_entity->entity_free_values_object) && is_array($curr_entity->entity_free_values_object) && count($curr_entity->entity_free_values_object) > 0){
			$custom_parameters = new \stdClass();
			foreach($curr_entity->entity_free_values_object as $free_val){
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
		if (appIsFile('Views/' .  $this->base_view_folder . 'page-' . $curr_entity->type . '.php')) {
			return view($this->base_view_folder . 'page-' .  $curr_entity->type, $this->web_ui_date->toArray());
		}
		return view($this->base_view_folder . 'page-default', $this->web_ui_date->toArray());
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
