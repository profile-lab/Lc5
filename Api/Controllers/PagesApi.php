<?php

namespace Lc5\Api\Controllers;

use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\PagesModel;
use Lc5\Web\Controllers\Pages;


final class PagesApi extends MasterApi
{
	use ResponseTrait;
	protected $response;

	//--------------------------------------------------------------------
	public function __construct()
	{
		$this->response = Services::response();
		$request = \Config\Services::request();
		$app_api_key = $request->header('x-api-key');
		if (!$app_api_key && ENVIRONMENT == 'development') {
			$app_api_key = $request->getGet('x-api-key');
		}
		$lcapps_model = new LcappsModel();
		if ($current_app_by_apikey = $lcapps_model->select(['id', 'apikey', 'nome', 'domain', 'is_in_maintenance_mode', 'status'])->where('apikey', $app_api_key)->asObject()->first()) {
			if (!defined('__web_app_id__')) {
				define('__web_app_id__', $current_app_by_apikey->id);
			} else {
				define('__web_app_id__', 000);
				define('__is_unauthorized__', 'Unauthorized');
			}
		} else {
			define('__web_app_id__', 000);
			define('__is_unauthorized__', 'Unauthorized');
		}
		parent::__construct(true);


		// '99bcbc09-baeb185f3a19bc72ceb2-a2f6927f-44d78fa0';
		// 'bb8ca12b-e6137428019aeac0ddc5-a8913461-0f7cdb4f';
		// 
	}



	//--------------------------------------------------------------------
	public function index()
	{
		return $this->page();
	}

	//--------------------------------------------------------------------
	public function page($guid = false)
	{
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
			return $this->apiservices->exitNotFound();
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
		$this->rest_data->entity = $curr_entity;
		// 
		$this->rest_data->entity_rows = $this->getEntityRows($curr_entity->id, 'pages');
		// 
		if (isset($this->custom_app_contoller) && $this->custom_app_contoller) {
			$custom_app_contoller_method = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[\s_]+/', ' ', str_replace(['-', '_'], ' ', $curr_entity->type)))));
			if (method_exists($this->custom_app_contoller, $custom_app_contoller_method)) {
				$this->custom_app_contoller->{$custom_app_contoller_method}($this);
			}
		}
		// 
		// 
		// if (isset($this->shop_settings_data) && $this->shop_settings_data) {
		// 	$this->web_ui_date->__set('shop_settings_data', $this->shop_settings_data);
		// 	if (trim($this->shop_settings_data->shop_home)) {
		// 		$shop_home_guid = trim(str_replace(['/'], '', $this->shop_settings_data->shop_home));
		// 		if ($shop_home_guid == $curr_entity->guid) {
		// 			$this->web_ui_date->__set('shop_home', true);
		// 			$this->web_ui_date->products_archive = $this->getShopProductsArchive();
		// 		}
		// 	}
		// }
		// 
		if ($this->rest_data) {
			$response = [
				'status' => 200,
				'error' => null,
				'message' => null,
				'data' => $this->rest_data
			];
			return $this->respond($response, 200);
			// return $this->apiservices->respond($this->rest_data);			
		}

		return $this->apiservices->exitNotFound();
	}
}
