<?php

namespace Lc5\Web\Controllers;

use App\Controllers\BaseController;
use Lc5\Data\Entities\WebUiData;

use Lc5\Data\Models\RowsModel;
use Lc5\Data\Models\MediaModel;
use Lc5\Data\Models\PostsModel;
use Lc5\Data\Models\PostscategoriesModel;
use Lc5\Data\Models\PostTagsModel;
use Lc5\Data\Models\PoststypesModel;
use stdClass;

class MasterWeb extends BaseController
{
	protected $base_view_folder = 'web/';
	protected $base_assets_folder = 'assets/web/';
	public $web_ui_date;
	protected $route_prefix;
	protected $module_name;
	protected $req;

	public $custom_app_contoller = null;


	//--------------------------------------------------------------------
	public function __construct()
	{
		$this->base_view_folder = (getenv('custom.web_base_folder')) ? 'Lc5\Web\Views/' . getenv('custom.web_base_folder') : '';
		$this->base_assets_folder = (getenv('custom.base_assets_folder')) ?: '/assets/';
		$this->req = \Config\Services::request();
		$locale = $this->req->getLocale();
		define('__locale__', $locale);
		define('__default_locale__', $this->req->config->defaultLocale);
		define('__locale_uri__', (__locale__ != getenv('app.defaultLocale')) ? __locale__ : '');
		define('__web_app_id__', getenv('custom.web_app_id'));
		define('__post_per_page__', (getenv('custom.post_per_page')) ?: 25);
		define('__base_assets_folder__', $this->base_assets_folder);
		// 
		$this->web_ui_date = new WebUiData();


		if($maintenance_view = $this->checkIsInMaintenance()){
			// if($maintenance_view == 'RETURN-TO-HP'){
			// 	exit();
			// }else{
				exit($maintenance_view);
			// }
		}

		$this->web_ui_date->__set('base_view_folder', $this->base_view_folder);
		// $this->web_ui_date->__set('lc_admin_menu', $this->getLcAdminMenu());
		// $this->web_ui_date->__set('lc_apps', $this->getLcApps());
		// $this->web_ui_date->__set('curr_lc_app', $this->getCurrApp());
		// $this->web_ui_date->__set('lc_languages', $this->getLcLanguages());
		// $this->web_ui_date->__set('curr_lc_lang', $this->getCurrLang());


		if (file_exists(APPPATH . 'Controllers/CustomAppContoller.php')) {
			$this->custom_app_contoller = new \App\Controllers\CustomAppContoller($this);		
		}

	}

	//--------------------------------------------------------------------
	protected function checkIsInMaintenance()
	{
		// 
		$is_in_maintenance = FALSE;
		if(ENVIRONMENT != 'production' || env('custom.maintenance_mode') == 'ACTIVE'){
			$admins = \Config\Services::admins();
			if($this->req->getPath() == 'add-maintainer'){
				return FALSE;
			}elseif(session()->__get('maintainer_user')){
				return FALSE;
			}elseif (!$admins->user_id()) {
				$is_in_maintenance = TRUE;
			}
		}


		if($is_in_maintenance){
			if (is_file(APPPATH.'Views/' .  $this->base_view_folder . 'maintenance.php')) {
				return view($this->base_view_folder . 'maintenance', $this->web_ui_date->toArray());
			}else{
				$this->base_view_folder = '\Lc5\Web\Views\default/';
				$this->web_ui_date->__set('base_view_folder', $this->base_view_folder);
				return view($this->base_view_folder.'maintenance', $this->web_ui_date->toArray());
			}
		}

		return FALSE;
	}

	//--------------------------------------------------------------------
	protected function getEntityRows($parent, $modulo)
	{
		// 
		$rows_model = new RowsModel();
		$rows_model->setForFrontemd();
		$media_model = new MediaModel();
		$media_model->setForFrontemd();

		// 
		$processedRow = $rows_model
			->asObject()
			->orderBy('ordine', 'ASC')
			->where('parent', $parent)
			->where('modulo', $modulo)
			->findAll();
		foreach ($processedRow as $row) {
			$row->data_object = json_decode($row->json_data);
			if ($row->data_object && is_iterable($row->data_object)) {
				foreach ($row->data_object as $data_object_item) {
					$data_object_item->guid = url_title($data_object_item->title, '-', TRUE);
					// 
					$data_object_item->img_path = null;
					$data_object_item->img_obj = null;
					if (isset($data_object_item->img_id) && $data_object_item->img_id > 0) {
						if ($data_object_item->img_obj = $media_model->find($data_object_item->img_id)) {
							$data_object_item->img_path = $data_object_item->img_obj->path;
						}
					}
					// 
				}
			}
			// 
			$custom_parameters = null;
			if (isset($row->free_values_object) && is_array($row->free_values_object) && count($row->free_values_object) > 0) {
				$custom_parameters = new stdClass();
				foreach ($row->free_values_object as $free_val) {
					$row->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
					$custom_parameters->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
				}
			}
			$row->custom_parameters = $custom_parameters;
			// 
			$row->guid = url_title($row->nome, '-', TRUE);
			if ($row->type != 'component') {
				if (appIsFile('Views/' .  $this->base_view_folder . 'rows/' . $row->type . '-' . $row->css_class . '.php')) {
					$row->view = $this->base_view_folder . 'rows/' . $row->type . '-' . $row->css_class;
				} else {
					$row->view = $this->base_view_folder . 'rows/' . $row->type;
				}
			} else {
				if (appIsFile('Views/' .  $this->base_view_folder . 'rows/php-component/' . $row->component . '.php')) {
					if (isset($row->dynamic_component)) {
						if (isset($row->dynamic_component->before_func) && trim($row->dynamic_component->before_func)) {
							if (function_exists($row->dynamic_component->before_func)) {
								// Function in custom_frontend_helper
								$row->method_data = call_user_func($row->dynamic_component->before_func, $row); //, $this->req
							} elseif (method_exists($this, $row->dynamic_component->before_func)) {
								// Method in controller web
								$row->method_data = $this->{$row->dynamic_component->before_func}($row);
							}
						}
					}
					$row->view = $this->base_view_folder . 'rows/php-component/' . $row->component;
				} else {
					$row->view = $this->base_view_folder . 'rows/php-component/empty';
				}
			}
		}
		return $processedRow;
	}

	//--------------------------------------------------------------------
	protected function getPostArchive(&$curr_entity)
	{
		// 
		if ($curr_entity->is_posts_archive) {

			// 
			$cur_post_cat_obj = null;
			$__curr_p_cat_guid = $this->req->getGet('p-cat') ?: null;
			$cur_post_tag_obj = null;
			$__curr_p_tag_guid = $this->req->getGet('p-tag') ?: null;
			// 

			$poststypes_model = new PoststypesModel();
			$poststypes_model->setForFrontemd();
			$postcat_model = new PostscategoriesModel();
			$postcat_model->setForFrontemd();
			$post_tags_model = new PostTagsModel();
			$post_tags_model->setForFrontemd();
			$posts_model = new PostsModel();
			$posts_model->setForFrontemd();
			if ($posts_archive_type = $poststypes_model->where('val', $curr_entity->is_posts_archive)->asObject()->first()) {
				// 
				$this->getPoststypesFieldsConfig($posts_archive_type);
				$orderby =  (isset($posts_archive_type->post_order) && $posts_archive_type->post_order != '') ? $posts_archive_type->post_order : 'id';
				$sortby =  (isset($posts_archive_type->post_sort) && $posts_archive_type->post_sort != '') ? $posts_archive_type->post_sort : 'DESC';
				$pagination_limit =  (isset($posts_archive_type->post_per_page) && $posts_archive_type->post_per_page != '') ? $posts_archive_type->post_per_page : __post_per_page__;
				// 
				$curr_entity->posts_archive_name = $posts_archive_type->nome;
				if ($posts_archive_type->has_archive) {
					if ($posts_archive_type->archive_root) {
						$curr_entity->posts_archive_index = site_url(__locale_uri__ . '/'. $posts_archive_type->archive_root);
					} else {
						$curr_entity->posts_archive_index = route_to(__locale_uri__ . 'web_posts_archive', $posts_archive_type->val);
					}
				} else {
					$curr_entity->posts_archive_index = null;
					$curr_entity->posts_archive_name = null;
				}
				// 
				$curr_entity->posts_castegories = $postcat_model->where('post_type', $posts_archive_type->id)->asObject()->findAll();
				if ($__curr_p_cat_guid) {
					$cur_post_cat_obj = $postcat_model->where('post_type', $posts_archive_type->id)->where('guid', $__curr_p_cat_guid)->asObject()->first();
				}
				// 
				$curr_entity->posts_tags = $post_tags_model->where('post_type', $posts_archive_type->id)->asObject()->findAll();
				if ($__curr_p_tag_guid) {
					$cur_post_tag_obj = $post_tags_model->where('post_type', $posts_archive_type->id)->where('val', $__curr_p_tag_guid)->asObject()->first();
				}
				// 

				$posts_qb = $posts_model->where('post_type', $posts_archive_type->id);
				if ($cur_post_cat_obj) {
					$posts_qb->where('category', $cur_post_cat_obj->id);
				}
				if ($cur_post_tag_obj) {
					$posts_qb->like('tags', '"' . $cur_post_tag_obj->id . '"', 'both');
				}

				if ($posts_archive = $posts_qb->asObject()->orderby('ordine', $sortby)->orderby($orderby, $sortby)->orderby('id', $sortby)->paginate($pagination_limit)) {
					foreach ($posts_archive as $post) {
						$post->abstract = word_limiter(strip_tags($post->testo), 20);
						$post->permalink = route_to(__locale_uri__ . 'web_posts_single', $posts_archive_type->val, $post->guid);
						// 
						$custom_parameters = null;
						if (isset($post->entity_free_values_object) && is_array($post->entity_free_values_object) && count($post->entity_free_values_object) > 0) {
							$custom_parameters = new \stdClass();
							foreach ($post->entity_free_values_object as $free_val) {
								$post->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
								$custom_parameters->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
							}
						}
						$post->entity_custom_parameters = $custom_parameters;
					}
					$curr_entity->posts_archive = $posts_archive;
				}
				$curr_entity->pager =  $posts_qb->pager;
			}
		}
	}

	//--------------------------------------------------------------------
	protected function getPoststypesFieldsConfig(&$curr_entity)
	{
		// 
		$curr_entity->post_attributes = [];
		// 
		if ($entity_fields_conf = json_decode($curr_entity->fields_config)->fields) {
			foreach ($entity_fields_conf as $post_attr) {
				$curr_entity->post_attributes[$post_attr] = true;
			}
		}
		// 
	}
}
