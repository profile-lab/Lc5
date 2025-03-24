<?php

namespace Lc5\Cms\Controllers;

use App\Controllers\BaseController;
use Lc5\Data\Entities\LcUiData;

use Lc5\Data\Models\LanguagesModel;
// use Lc5\Data\Models\CustomFieldsKeysModel;
use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\AppSettingsModel;
// use Lc5\Data\Models\ShopSettingsModel;

use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\RowsModel;
use Lc5\Data\Models\RowcomponentsModel;
use Lc5\Data\Models\RowcolorModel;
use Lc5\Data\Models\RowextrastyleModel;
use Lc5\Data\Models\RowsstyleModel;
use Lc5\Data\Models\MediaformatModel;

use Lc5\Data\Models\PoststypesModel;

use Lc5\Data\Entities\Row;
use Vimeo\Vimeo;

class MasterLc extends BaseController
{
	protected $req;
	// 
	protected $lc_ui_date;
	// 
	protected $entity_custom_fileds_targets;
	protected $app_custom_fields_keys;
	// 
	protected $current_lc_controller = '';
	protected $current_lc_module = '';
	protected $current_lc_sub_module = '';
	protected $current_lc_method = '';
	protected $curr_lc_lang;
	protected $module_name;
	protected $route_prefix;
	protected $default_lc_lang;
	protected $current_app_data;
	protected $current_archive_base_root = 'archive/';

	// 
	protected $vimeo_client = null;
	// 
	protected $project_settings = null;
	// 
	// protected $lc_plugin_modules = [];
	// 


	//--------------------------------------------------------------------
	public function __construct()
	{
		$this->lc_ui_date = new LcUiData();
		// d($this->lc_ui_date);
		$this->req = \Config\Services::request();

		$this->project_settings = $this->getProjectSettings();
		// 
		$this->current_app_data = $this->getAppData($this->getCurrApp());
		$this->default_lc_lang = $this->getDefaultLang();
		$this->curr_lc_lang = $this->getCurrLang();
		// 
		$this->lc_ui_date->__set('lc_admin_menu', $this->getLcAdminMenu());
		$this->lc_ui_date->__set('lc_apps', $this->getLcApps());
		$this->lc_ui_date->__set('curr_lc_app', $this->getCurrApp());
		$this->lc_ui_date->__set('lc_languages', $this->getLcLanguages());
		$this->lc_ui_date->__set('curr_lc_app_data', $this->current_app_data);
		$this->lc_ui_date->__set('default_lc_lang', $this->default_lc_lang);
		$this->lc_ui_date->__set('curr_lc_lang', $this->curr_lc_lang);
		if ($this->curr_lc_lang == 'it') {
			$this->current_archive_base_root = 'archivio/';
		}
		// 
		// 
		$this->current_lc_method = service('router')->methodName();
		$this->lc_ui_date->__set('current_lc_method', $this->current_lc_method);
		// 
		$this->getCurrentModule(); // SET current_lc_controller & current_lc_module & current_lc_sub_module
		$this->lc_ui_date->__set('current_lc_controller', $this->current_lc_controller);
		$this->lc_ui_date->__set('current_lc_module', $this->current_lc_module);
		$this->lc_ui_date->__set('currernt_module', $this->current_lc_module);
		$this->lc_ui_date->__set('current_lc_sub_module', $this->current_lc_sub_module);
		$this->lc_ui_date->__set('currernt_module_action', $this->getCurrentModuleAction());
		// 
		$this->lc_ui_date->__set('is_vimeo_enabled', $this->checkVimeoSetting());
		// 
		// 
		$this->entity_custom_fileds_targets = [
			"pages" => (object) ["nome" => "Pagine", "val" => "pages"],
			"posts" => (object) ["nome" => "Posts", "val" => "posts"],
			"categories" => (object) ["nome" => "Categorie", "val" => "categories"],

			"simple_par" => (object) ["nome" => "Paragrafo", "val" => "simple_par"],
			"gallery_par" => (object) ["nome" => "Gallery", "val" => "gallery_par"],
			"columns_par" => (object) ["nome" => "Colonne", "val" => "columns_par"],
			"component_par" => (object) ["nome" => "Componente", "val" => "component_par"],

			"prodotti" => (object) ["nome" => "Prodotti", "val" => "prodotti"],
			"prod_categories" => (object) ["nome" => "Categorie Prodotti", "val" => "prod_categories"],
		];
		$this->app_custom_fields_keys = $this->getCustomFieldsKeys();
		foreach ($this->entity_custom_fileds_targets as $c_cft) {
			$this->lc_ui_date->__set('custom_fields_keys_' . $c_cft->val, $this->getCustomFieldsKeysByTarget($c_cft->val));
		}
		// 
		// 
		$this->lc_ui_date->__set('row_styles_conf_css', $this->getRowStylesCss());
		// 
		// 
		$this->lc_ui_date->__set('boolean_select', [
			"0" => (object) ["nome" => "NO", "val" => "0"],
			"1" => (object) ["nome" => "YES", "val" => "1"]
		]);
		// 
		// 
		$this->lc_getErrorMess();
	}
	//--------------------------------------------------------------------
	//--------------------------------------------------------------------

	protected function getProjectSettings()
	{
		$file_path = ROOTPATH.'project-settings.php'; 
		if(file_exists($file_path)){       
			require_once $file_path;
			$settings_class_name = 'ProjectSettings'; 
			if(class_exists($settings_class_name)){    
				$project_settings = new $settings_class_name();
				return $project_settings;
			}
		}
	}

	//--------------------------------------------------------------------
	protected function getProjectSettingsValue($key)
	{
		if($this->project_settings){
			$curr_app = $this->getCurrApp();
			if(isset($this->project_settings->{$key})){
				if(isset($this->project_settings->{$key}[$curr_app])){
					return $this->project_settings->{$key}[$curr_app];
				}
			}
		}
		return null;
	}

	// //--------------------------------------------------------------------
	// protected function createBeseShopSettings($__id_app = null)
	// {
	// 	if (!$__id_app) {
	// 		$__id_app = $this->getCurrApp();
	// 	}

	// 	$shop_settings_model = new ShopSettingsModel();
	// 	$new_base_entity = new \Lc5\Data\Entities\Shopsettings();
	// 	$new_base_entity->id_app = $__id_app;
	// 	$new_base_entity->entity_free_values = '[]';
	// 	$new_base_entity->discount_type = 'PRICE';
	// 	if ($shop_settings_model->save($new_base_entity)) {
	// 		return TRUE;
	// 	}
	// 	return FALSE;
	// }

	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	protected function createBeseAppSettings($__id_app = null, $__lang = null)
	{
		if (!$__id_app) {
			$__id_app = $this->getCurrApp();
		}
		if (!$__lang) {
			$__lang = $this->getCurrLang();
		}
		$app_settings_model = new AppSettingsModel();
		$new_base_entity = new \Lc5\Data\Entities\AppSetting();
		$new_base_entity->id_app = $__id_app;
		$new_base_entity->lang = strtolower($__lang);
		$new_base_entity->entity_free_values = '[]';
		if ($app_settings_model->save($new_base_entity)) {
			return TRUE;
		}
		return FALSE;
	}

	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	public function getCurrentModule()
	{

		$this->current_lc_module = '';
		$this->current_lc_sub_module = '';
		$module = '';
		$controller  = service('router')->controllerName();
		$controller_str = strtolower(str_replace("\Lc5\Cms\Controllers\\", '', $controller));
		$this->current_lc_controller = $controller_str;
		$controller_str_arr =  explode("\\",   $controller_str);
		$module = $controller_str_arr[0];

		$this->current_lc_module = $controller_str_arr[0];
		$this->current_lc_sub_module = (isset($controller_str_arr[1])) ? $controller_str_arr[1] : null;
	}
	//--------------------------------------------------------------------
	public function getCurrentModuleAction()
	{
		return ($this->current_lc_method != 'edit') ? $this->current_lc_method  : 'index';
	}
	//--------------------------------------------------------------------
	public function cambiaLang($lang)
	{
		$languages_model = new LanguagesModel();
		if ($lang = $languages_model->where('val', $lang)->first()) {

			$data = ['curr_lc_lang' => strtolower($lang->val)];
			session()->set($data);
			return redirect()->route('lc_dashboard');
		}
	}
	//--------------------------------------------------------------------
	public function cambiaApp($id)
	{
		$languages_model = new LanguagesModel();
		$lcapps_model = new LcappsModel();
		if ($app = $lcapps_model->find($id)) {
			$data = ['curr_lc_app' => $app->id];
			session()->set($data);
			$def_app_lang = $this->getDefaultLang();

			if ($lang = $languages_model->where('val', $def_app_lang)->first()) {
				$data = ['curr_lc_lang' => strtolower($lang->val)];
				session()->set($data);
			}

			return redirect()->route('lc_dashboard');
		}
	}

	//--------------------------------------------------------------------
	protected function getRowStylesCss($all_obj = false)
	{
		$return_css_code = '<style>';

		$rows_style_model = new RowsstyleModel();
		if ($rows_styles_css_data = $rows_style_model->asObject()->findAll()) {
			foreach ($rows_styles_css_data as $row_style_data) {
				$fields_to_hide = [];
				$entity_fields_conf_byjson = json_decode(($row_style_data->fields_config) ?: '');
				if (json_last_error() === JSON_ERROR_NONE) {
					$fields_to_hide = $entity_fields_conf_byjson->fields;
				}

				foreach ($fields_to_hide as $val) {
					// d($row_style_data->val);
					$return_css_code .= "div.card-body[meta-type='$row_style_data->val'] .form-field-" . $row_style_data->type . "_" . $val . "{ display: none !important; } ";
				}
			}
		}
		$rows_config_styles = $this->getProjectSettingsValue('rows_config_styles');
		if($rows_config_styles){
			foreach($rows_config_styles as $row_config){
				$row_style_data = (object) $row_config;
				$fields_to_hide = [];
				$entity_fields_conf_byjson = json_decode(($row_style_data->fields_config) ?: '');
				if (json_last_error() === JSON_ERROR_NONE) {
					$fields_to_hide = $entity_fields_conf_byjson->fields;
					foreach ($fields_to_hide as $key => $val) {
						$return_css_code .= "div.card-body[meta-type='$row_style_data->val'] .form-field-" . $row_style_data->type . "_" . $val . "{ display: none !important; } ";
					}
				}
			}
		}
		$return_css_code .= '</style>';
		return $return_css_code;
	}
	//--------------------------------------------------------------------
	protected function getDefaultLang($all_obj = false)
	{
		$languages_model = new LanguagesModel();
		if ($lang = $languages_model->where('is_default', 1)->first()) {
			if ($all_obj) {
				return $lang;
			} else {
				return $lang->val;
			}
		} else {
		}
	}
	//--------------------------------------------------------------------
	protected function getCurrLang()
	{
		if ($curr_lc_lang = session()->get('curr_lc_lang')) {
			return $curr_lc_lang;
		}
		return null;
	}
	//--------------------------------------------------------------------
	protected function getLcLanguages()
	{
		$languages_model = new LanguagesModel();
		return $languages_model->asObject()->findAll();
	}
	//--------------------------------------------------------------------
	protected function getCustomFieldsKeys()
	{
		if (class_exists('\Lc5\Data\Models\CustomFieldsKeysModel')) {
			$custom_fields_keys_model = new \Lc5\Data\Models\CustomFieldsKeysModel();
			return $custom_fields_keys_model->asObject()->findAll();
		}
		return FALSE;
	}
	//--------------------------------------------------------------------
	protected function getCustomFieldsKeysByTarget($target_type)
	{
		$return_fields = [];
		if (!$this->app_custom_fields_keys) {
			$this->app_custom_fields_keys = $this->getCustomFieldsKeys();
		}
		if (is_iterable($this->app_custom_fields_keys)) {
			foreach ($this->app_custom_fields_keys as $c_cust_field_key) {
				if (is_array($target_type)) {
					if (in_array($c_cust_field_key->target, $target_type)) {
						$return_fields[] = $c_cust_field_key;
					}
				} else {
					if ($c_cust_field_key->target == $target_type) {
						$return_fields[] = $c_cust_field_key;
					}
				}
			}
		}

		return $return_fields;
	}




	//--------------------------------------------------------------------
	protected function getDefaultApp($all_obj = false)
	{
		$lcapps_model = new LcappsModel();
		if ($lcapp = $lcapps_model->first()) {
			if ($all_obj) {
				return $lcapp;
			} else {
				return $lcapp->id;
			}
		} else {
		}
	}
	//--------------------------------------------------------------------
	protected function getCurrApp()
	{
		if ($curr_lc_app = session()->get('curr_lc_app')) {
			return $curr_lc_app;
		}
		return null;
	}
	//--------------------------------------------------------------------
	protected function getLcApps()
	{
		$lcapps_model = new LcappsModel();
		return $lcapps_model->asObject()->findAll();
	}
	//--------------------------------------------------------------------
	protected function getAppData($__id_app = null)
	{
		if ($__id_app) {
			$lcapps_model = new LcappsModel();
			if ($app_data = $lcapps_model->asObject()->find($__id_app)) {
				return $app_data;
			}
		}
		return null;
	}
	//--------------------------------------------------------------------
	protected function getAppDataField($__field = null)
	{
		if ($__field && $this->current_app_data) {
			if (isset($this->current_app_data->{$__field}) && trim($this->current_app_data->{$__field})) {
				return $this->current_app_data->{$__field};
			}
		}
		return null;
	}


	//--------------------------------------------------------------------
	protected function pageListByLevel($parent = 0, $pre_name = '', $exclude_id = null, $parent_guid = '')
	{
		$pages_model = new PagesModel();
		$level_page_list = [];

		$pages_l1_qb = $pages_model->select('id, id as val, nome, titolo, is_home, parent, guid, type')->where('id !=', $exclude_id);
		if ($parent > 0) {
			$pages_l1_qb->where('parent', $parent);
		} else {
			$pages_l1_qb->where('parent', 0);
		}
		$pages_l1 = $pages_l1_qb->asObject()->findAll();
		if ($pages_l1) {
			// dd($pages_l1);
			foreach ($pages_l1 as $key => $page) {
				$page->guid = $parent_guid . '/' . $page->guid;
				$page->frontend_guid = null;
				if ($app_domain = $this->getAppDataField('domain')) {
					$page->frontend_guid = reduce_double_slashes($app_domain . '/' . (($this->curr_lc_lang != $this->default_lc_lang) ? $this->curr_lc_lang : '')  . $page->guid);
				}
				$page->label = $page->nome;
				$page->nome = $pre_name . (($pre_name != '') ? ' ' : '') . $page->nome;
				$page->children = $this->pageListByLevel($page->id, ($pre_name != '') ? $pre_name . '-' : '', $exclude_id, $page->guid);
				$level_page_list[] = $page;
			}
			return $level_page_list;
		}
		return null;
	}


	//--------------------------------------------------------------------
	protected function getLcAdminMenu()
	{
		$LcShopConfigsClassNamespace = '\LcShop\Cms\Controllers\LcShopConfigs'; 
        if(class_exists($LcShopConfigsClassNamespace)){
			$this->lc_plugin_modules = array_merge($this->lc_plugin_modules, $LcShopConfigsClassNamespace::getLcModulesMenu());
        }
		// 
		$LcUsersConfigsClassNamespace = '\LcUsers\Cms\Controllers\LcUsersConfigs'; 
        if(class_exists($LcUsersConfigsClassNamespace)){
			$this->lc_plugin_modules = array_merge($this->lc_plugin_modules, $LcUsersConfigsClassNamespace::getLcModulesMenu());
        }
		// 

		$posts_icos = ['news' => 'paperclip', 'faq' => 'question-mark'];
		$menu_data_arr = [];

		// 
		$menu_data_arr['dashboard'] = (object) [
			'label' => 'Dashboard',
			'route' => site_url(route_to('lc_dashboard')),
			'module' => 'dashboard',
			'ico' => 'home'
		];
		// 
		// Pagine 
		$menu_data_arr['pages'] = (object) [
			'label' => 'Pagine',
			'route' => site_url(route_to('lc_pages')),
			'module' => 'pages',
			'ico' => 'book',
			'items' => [
				(object) [
					'label' => 'Lista Pagine',
					'route' => site_url(route_to('lc_pages')),
					'module_action' => 'index',
				],
				(object) [
					'label' => 'Nuova Pagina',
					'route' => site_url(route_to('lc_pages_new')),
					'module_action' => 'newpost',
				]
			]
		];
		// 

		// 
		$poststypes_model = new PoststypesModel();
		// 
		if ($poststypes = $poststypes_model->findAll()) {
			foreach ($poststypes as $post_type) {

				// Posts 
				$menu_data_arr['posts_' . $post_type->val] = (object) [
					'label' => $post_type->nome,
					'route' => site_url(route_to('lc_posts', $post_type->val)),
					'module' => 'posts_' . $post_type->val,
					'ico' => (isset($posts_icos[$post_type->val])) ? $posts_icos[$post_type->val] :  'pin',
					'items' => [
						(object) [
							'label' => 'Lista ' . $post_type->nome,
							'route' => site_url(route_to('lc_posts', $post_type->val)),
							'module_action' => 'index',
						],
						(object) [
							'label' => 'New ' . $post_type->nome,
							'route' => site_url(route_to('lc_posts_new', $post_type->val)),
							'module_action' => 'newpost',
						],
						(object) [
							'label' => 'Categorie',
							'route' => site_url(route_to('lc_posts_cat', $post_type->val)),
							'module_action' => 'postscategories',
						],
						(object) [
							'label' => 'Tags',
							'route' => site_url(route_to('lc_posts_tags', $post_type->val)),
							'module_action' => 'poststags',
						]
					]
				];
				// 
			}
		}

		if (isset($this->lc_plugin_modules) && is_array($this->lc_plugin_modules) && count($this->lc_plugin_modules)) {
			foreach ($this->lc_plugin_modules as $plugin_key => $plugin_module) {

				$plugin_module = (object) $plugin_module;
				$plugin_module_items_array = [];
				if (isset($plugin_module->items) && $plugin_module->items && count($plugin_module->items) > 0) {
					foreach ($plugin_module->items as $plugin_module_item) {
						$plugin_module_item_obj = (object) $plugin_module_item;
						$plugin_module_item_obj->route = site_url(route_to($plugin_module_item_obj->route));
						$plugin_module_items_array[] = $plugin_module_item_obj;
					}
				}
				$menu_data_arr[$plugin_key] = (object) [
					'label' => $plugin_module->label,
					// 'route' => site_url(route_to($plugin_module->route)),
					'route' => route_to($plugin_module->route),
					'module' => $plugin_module->module,
					'ico' => $plugin_module->ico,
					// 'items' =>$plugin_module_items_array,
				];
				if (count($plugin_module_items_array) > 0) {
					$menu_data_arr[$plugin_key]->items = $plugin_module_items_array;
				}
			}
		}

		// Media 
		$menu_data_arr['media'] = (object) [
			'label' => 'Media',
			'route' => site_url(route_to('lc_media')),
			'module' => 'media',
			'ico' => 'image',
			'items' => [
				(object) [
					'label' => 'Lista Media',
					'route' => site_url(route_to('lc_media')),
					'module_action' => 'index',
				],
				(object) [
					'label' => 'Nuovo Media',
					'route' => site_url(route_to('lc_media_new')),
					'module_action' => 'newpost',

				],
				(object) [
					'label' => 'Formati',
					'route' => site_url(route_to('lc_media_formati')),
					'module_action' => 'mediaformat',
				]
			]
		];
		// 

		// Menu 
		$menu_data_arr['menus'] = (object) [
			'label' => 'Menu',
			'route' => site_url(route_to('lc_menus')),
			'module' => 'sitemenus',
			'ico' => 'menu',
			'items' => [
				(object) [
					'label' => 'Lista Menu',
					'route' => site_url(route_to('lc_menus')),
					'module_action' => 'index',
				],
				(object) [
					'label' => 'Nuovo Menu',
					'route' => site_url(route_to('lc_menus_new')),
					'module_action' => 'newpost',
				]
			]
		];
		//

		if (isset($this->custom_app_modules) && is_array($this->custom_app_modules)) {
			foreach ($this->custom_app_modules as $cm_key => $custom_modulo_arr) {
				$custom_modulo = (object) $custom_modulo_arr;

				// Posts 
				$menu_data_arr['custom_' . $custom_modulo->nome] = (object) [
					'label' => $custom_modulo->nome,
					'route' => site_url(route_to($custom_modulo->lc_base_route)),
					'module' => $cm_key,
					'ico' => 'pin',
				];
				// 
			}
		}


		// Tools 
		$menu_data_arr['tools'] = (object) [
			'label' => 'Tools',
			'root' => '#',
			'module' => 'tools',
			'ico' => 'wrench',
			'items' => [
				(object) [
					'label' => 'Tipologie pagine',
					'route' => site_url(route_to('lc_tools_pagetypes')),
					'module_action' => 'pagestype',
				],
				(object) [
					'label' => 'Tipologie paragrafi',
					'route' => site_url(route_to('lc_tools_rows_styles')),
					'module_action' => 'rowsstyle',
				],
				(object) [
					'label' => 'Colori paragrafi',
					'route' => site_url(route_to('lc_tools_rows_colors')),
					'module_action' => 'rowscolor',
				],
				(object) [
					'label' => 'Stili extra paragrafi',
					'route' => site_url(route_to('lc_tools_rows_extra_styles')),
					'module_action' => 'rowextrastyles',
				],
				(object) [
					'label' => 'Componenti dinamici',
					'route' => site_url(route_to('lc_tools_rows_componet')),
					'module_action' => 'rowcomponent',
				],
				(object) [
					'label' => 'Tipologie post',
					'route' => site_url(route_to('lc_tools_poststypes')),
					'module_action' => 'poststypes',
				],
				(object) [
					'label' => 'Lingue',
					'route' => site_url(route_to('lc_languages')),
					'module_action' => 'language',
				],
				(object) [
					'label' => 'Chiavi custom fields',
					'route' => site_url(route_to('lc_tools_custom_fields_keys')),
					'module_action' => 'customfieldskeys',
				],
				// (object) [
				// 	'label' => 'Labels',
				// 	'route' => site_url(route_to('lc_labels')),
				// 'module_action' => '',
				// ],
				(object) [
					'label' => 'Apps',
					'route' => site_url(route_to('lc_apps')),
					'module_action' => 'lcapps',
				],
				(object) [
					'label' => 'Lc Tools',
					'route' => site_url(route_to('lc_tools_index')),
					'module_action' => 'lc_tools_index',
				],
			]
		];
		//

		// Settings
		$menu_data_arr['settings'] = (object) [
			'label' => 'Settings',
			'route' => site_url(route_to('lc_app_settings')),
			'module' => 'appsettings',
			'ico' => 'cog'
		];
		// 

		// Menu 
		$menu_data_arr['admins'] = (object) [
			'label' => 'Admins',
			'route' => site_url(route_to('lc_admin_users')),
			'module' => 'adminusers',
			'ico' => 'people',
			'items' => [
				(object) [
					'label' => 'Lista Admin',
					'route' => site_url(route_to('lc_admin_users')),
					'module_action' => 'index',
				],
				(object) [
					'label' => 'Nuovo Admin',
					'route' => site_url(route_to('lc_admin_users_new')),
					'module_action' => 'newpost',
				]
			]
		];
		//

		return $menu_data_arr;
	}

	//--------------------------------------------------------------------
	protected function lc_parseValidator($errors)
	{
		$model_error_str = '';
		if (!empty($errors)) {
			foreach ($errors as $field => $error) {
				$model_error_str .= '<div class="error_row">' . $error . '</div>';
			}
		}
		return $model_error_str;
	}

	//--------------------------------------------------------------------
	protected function lc_setErrorMess($ui_mess = null, $ui_mess_type = 'alert-warning')
	{
		if ($ui_mess) {
			session()->setFlashdata('ui_mess',  $ui_mess);
			session()->setFlashdata('ui_mess_type', $ui_mess_type);
		}
	}

	//--------------------------------------------------------------------
	protected function lc_getErrorMess()
	{
		$ui_mess = session()->getFlashdata('ui_mess');
		$ui_mess_type = session()->getFlashdata('ui_mess_type');
		$this->lc_ui_date->ui_mess =  ((isset($ui_mess)) ? $ui_mess : null);
		$this->lc_ui_date->ui_mess_type =  ((isset($ui_mess_type)) ? 'alert ' . $ui_mess_type : null);
	}

	//--------------------------------------------------------------------
	protected function editEntityRows($parent, $modulo)
	{
		// 
		$rows_model = new RowsModel();
		// 
		// Rimuovi rows da eliminare
		//
		if ($this->req->getPost('rows_to_del')) {
			$arr_to_del = explode('#', $this->req->getPost('rows_to_del'));
			foreach ($arr_to_del as $row_to_del) {
				$curr_row_entity_del = $rows_model->find($row_to_del);
				$rows_model->delete($curr_row_entity_del->id);
			}
		}
		// 
		// FINE Rimuovi rows da eliminare
		// 

		// 
		// Paragrafi base
		// 
		$type = 'simple';
		$prefix = $type . '_';
		if (isset($_POST[$prefix . 'id'])) {
			$count_type = 0;
			foreach ($_POST[$prefix . 'id'] as $row_id) {
				if (is_numeric($row_id)) {
					$curr_row_entity = $rows_model->find($row_id);
				} else {
					$curr_row_entity = new Row();
				}
				// 
				$curr_row_entity->master_row = intval($curr_row_entity->master_row) + 1;
				$curr_row_entity->parent = $parent;
				$curr_row_entity->type = $this->req->getPost($prefix . 'type')[$count_type];
				$curr_row_entity->modulo = $modulo;
				$curr_row_entity->ordine = $this->req->getPost($prefix . 'ordine')[$count_type];
				$curr_row_entity->nome = $this->req->getPost($prefix . 'nome')[$count_type];
				$curr_row_entity->titolo = $this->req->getPost($prefix . 'titolo')[$count_type];
				$curr_row_entity->sottotitolo = $this->req->getPost($prefix . 'sottotitolo')[$count_type];
				$curr_row_entity->testo = $this->req->getPost($prefix . 'testo')[$count_type];
				$curr_row_entity->css_class = $this->req->getPost($prefix . 'css_class')[$count_type];
				$curr_row_entity->css_color = $this->req->getPost($prefix . 'css_color')[$count_type];
				$curr_row_entity->css_extra_class = $this->req->getPost($prefix . 'css_extra_class')[$count_type];
				$curr_row_entity->formato_media = $this->req->getPost($prefix . 'formato_media')[$count_type];
				$curr_row_entity->main_img_id = $this->req->getPost($prefix . 'main_img_id')[$count_type];
				$curr_row_entity->gallery = $this->req->getPost($prefix . 'gallery')[$count_type];

				$curr_row_entity->cta_url  = $this->req->getPost($prefix . 'cta_url')[$count_type];
				$curr_row_entity->cta_label = $this->req->getPost($prefix . 'cta_label')[$count_type];

				$curr_row_entity->video_url  = $this->req->getPost($prefix . 'video_url')[$count_type];
				// 
				$curr_row_entity->free_values = $this->req->getPost($prefix . 'free_values')[$count_type];
				// 
				if ($curr_row_entity->hasChanged()) {
					$rows_model->save($curr_row_entity);
				}
				$count_type++;
			}
		}
		// 
		// Paragrafi base
		//

		// 
		// Paragrafi columns
		// 
		$type = 'columns';
		$prefix = $type . '_';
		if (isset($_POST[$prefix . 'id'])) {
			$count_type = 0;
			foreach ($_POST[$prefix . 'id'] as $row_id) {
				if (is_numeric($row_id)) {
					$curr_row_entity = $rows_model->find($row_id);
				} else {
					$curr_row_entity = new Row();
				}
				// 
				$curr_row_entity->master_row = intval($curr_row_entity->master_row) + 1;
				$curr_row_entity->parent = $parent;
				$curr_row_entity->type = $this->req->getPost($prefix . 'type')[$count_type];
				$curr_row_entity->modulo = $modulo;
				$curr_row_entity->ordine = $this->req->getPost($prefix . 'ordine')[$count_type];
				$curr_row_entity->nome = $this->req->getPost($prefix . 'nome')[$count_type];
				$curr_row_entity->titolo = $this->req->getPost($prefix . 'titolo')[$count_type];
				$curr_row_entity->sottotitolo = $this->req->getPost($prefix . 'sottotitolo')[$count_type];
				$curr_row_entity->css_class = $this->req->getPost($prefix . 'css_class')[$count_type];
				$curr_row_entity->css_color = $this->req->getPost($prefix . 'css_color')[$count_type];
				$curr_row_entity->css_extra_class = $this->req->getPost($prefix . 'css_extra_class')[$count_type];
				$curr_row_entity->formato_media = $this->req->getPost($prefix . 'formato_media')[$count_type];
				$curr_row_entity->main_img_id = $this->req->getPost($prefix . 'main_img_id')[$count_type];

				$curr_row_entity->json_data = $this->req->getPost($prefix . 'json_data')[$count_type];
				// 
				$curr_row_entity->free_values = $this->req->getPost($prefix . 'free_values')[$count_type];
				// 
				if ($curr_row_entity->hasChanged()) {
					$rows_model->save($curr_row_entity);
				}
				$count_type++;
			}
		}
		// 
		// Paragrafi columns
		//

		// 
		// Paragrafi gallery
		// 
		$type = 'gallery';
		$prefix = $type . '_';
		if (isset($_POST[$prefix . 'id'])) {
			$count_type = 0;
			foreach ($_POST[$prefix . 'id'] as $row_id) {
				if (is_numeric($row_id)) {
					$curr_row_entity = $rows_model->find($row_id);
				} else {
					$curr_row_entity = new Row();
				}
				// 
				$curr_row_entity->master_row = intval($curr_row_entity->master_row) + 1;
				$curr_row_entity->parent = $parent;
				$curr_row_entity->type = $this->req->getPost($prefix . 'type')[$count_type];
				$curr_row_entity->modulo = $modulo;
				$curr_row_entity->ordine = $this->req->getPost($prefix . 'ordine')[$count_type];
				$curr_row_entity->nome = $this->req->getPost($prefix . 'nome')[$count_type];
				$curr_row_entity->titolo = $this->req->getPost($prefix . 'titolo')[$count_type];
				$curr_row_entity->sottotitolo = $this->req->getPost($prefix . 'sottotitolo')[$count_type];
				$curr_row_entity->css_class = $this->req->getPost($prefix . 'css_class')[$count_type];
				$curr_row_entity->css_color = $this->req->getPost($prefix . 'css_color')[$count_type];
				$curr_row_entity->css_extra_class = $this->req->getPost($prefix . 'css_extra_class')[$count_type];
				$curr_row_entity->formato_media = $this->req->getPost($prefix . 'formato_media')[$count_type];
				$curr_row_entity->json_data = $this->req->getPost($prefix . 'json_data')[$count_type];
				// 
				$curr_row_entity->free_values = $this->req->getPost($prefix . 'free_values')[$count_type];
				// 
				if ($curr_row_entity->hasChanged()) {
					$rows_model->save($curr_row_entity);
				}
				$count_type++;
			}
		}
		// 
		// Paragrafi gallery
		//

		// 
		// Paragrafi component
		// 
		$type = 'component';
		$prefix = $type . '_';
		if (isset($_POST[$prefix . 'id'])) {
			$count_type = 0;
			foreach ($_POST[$prefix . 'id'] as $row_id) {
				if (is_numeric($row_id)) {
					$curr_row_entity = $rows_model->find($row_id);
				} else {
					$curr_row_entity = new Row();
				}
				// 
				$curr_row_entity->master_row = intval($curr_row_entity->master_row) + 1;
				$curr_row_entity->parent = $parent;
				$curr_row_entity->type = $this->req->getPost($prefix . 'type')[$count_type];
				$curr_row_entity->modulo = $modulo;
				$curr_row_entity->ordine = $this->req->getPost($prefix . 'ordine')[$count_type];
				$curr_row_entity->nome = $this->req->getPost($prefix . 'nome')[$count_type];
				$curr_row_entity->titolo = $this->req->getPost($prefix . 'titolo')[$count_type];
				$curr_row_entity->sottotitolo = $this->req->getPost($prefix . 'sottotitolo')[$count_type];
				$curr_row_entity->component = $this->req->getPost($prefix . 'component')[$count_type];
				$curr_row_entity->component_params = $this->req->getPost($prefix . 'component_params')[$count_type];
				$curr_row_entity->css_color = $this->req->getPost($prefix . 'css_color')[$count_type];
				// 
				$curr_row_entity->main_img_id = $this->req->getPost($prefix . 'main_img_id')[$count_type];
				// 
				// $curr_row_entity->css_extra_class = $this->req->getPost($prefix . 'css_extra_class')[$count_type];
				// $curr_row_entity->formato_media = $this->req->getPost($prefix . 'formato_media')[$count_type];
				// $curr_row_entity->json_data = $this->req->getPost($prefix . 'json_data')[$count_type];
				// 
				$curr_row_entity->free_values = $this->req->getPost($prefix . 'free_values')[$count_type];
				// 
				if ($curr_row_entity->hasChanged()) {
					$rows_model->save($curr_row_entity);
				}
				$count_type++;
			}
		}
		// 
		// Paragrafi component
		//


		// 
		$curr_row_entity = new Row();
		// 

	}

	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	protected function getRowComponents()
	{

		$rows_components_model = new RowcomponentsModel();
		$qb = $rows_components_model->orderBy('nome', 'ASC')->orderBy('nome', 'ASC');
		$dbRowsComponents = $qb->findAll();
		if($dbRowsComponents){
			foreach($dbRowsComponents as $dbRowComponent){
				$dati[] = $dbRowComponent;
			}
		}
		$rows_components_config = $this->getProjectSettingsValue('rows_components_config');
		if($rows_components_config){
			foreach($rows_components_config as $row_component){
				$dati[] = (object) $row_component;
			}
		}

		return $dati;
	}
	//--------------------------------------------------------------------
	protected function getRowColors()
	{
		$rows_colors_model = new RowcolorModel();
		$datiDb = $rows_colors_model->asObject()->findAll();
		$dati = [];
		if ($datiDb) {
			foreach ($datiDb as $dato) {
				$dati[] = (object) ['val' => $dato->val, 'nome' => $dato->nome];
			}
		}
		$rows_colors = $this->getProjectSettingsValue('rows_colors');
		if($rows_colors){
			foreach($rows_colors as $rows_color){
				$dati[] = (object) ['val' => $rows_color['val'], 'nome' => $rows_color['nome']];
			}
		}
		if(count($dati) > 0){
			$dati[] = (object) ['val' => '', 'nome' => 'Nessuno'];
		}
		return $dati;
	}
	//--------------------------------------------------------------------
	protected function getRowExtraStyles()
	{
		$rows_extra_styles_model = new RowextrastyleModel();
		$datiDb = $rows_extra_styles_model->asObject()->findAll();
		$dati = [];
		if ($datiDb) {
			foreach ($datiDb as $dato) {
				$dati[] = (object) ['val' => $dato->val, 'nome' => $dato->nome];
			}
		}
		$rows_extra_styles = $this->getProjectSettingsValue('rows_extra_styles');
		if($rows_extra_styles){
			foreach($rows_extra_styles as $row_extra_style){
				$dati[] = (object) ['val' => $row_extra_style['val'], 'nome' => $row_extra_style['nome']];
			}
		}
		if(count($dati) > 0){
			$dati[] = (object) ['val' => '', 'nome' => 'Nessuno'];
		}
		return $dati;
	}
	//--------------------------------------------------------------------
	protected function getRowStyles($__type = null)
	{
		$rows_style_model = new RowsstyleModel();
		$qb = $rows_style_model->orderBy('ordine', 'ASC')->orderBy('nome', 'ASC');
		if ($__type) {
			$qb->whereIn('type', [$__type, '']);
		}
		$allRowsStyles = $qb->findAll();
		$rows_config = $this->getProjectSettingsValue('rows_config_styles');
		if($rows_config){
			foreach($rows_config as $row_config){
				if($__type){
					if($row_config['type'] != $__type){
						continue;
					}
				}
				$allRowsStyles[] = (object) $row_config;
			}
		}

		return $allRowsStyles;
	}

	//--------------------------------------------------------------------
	protected function getEntityRows($parent, $modulo)
	{
		// 
		$rows_model = new RowsModel();
		// 
		$processedRow = $rows_model
			->orderBy('ordine', 'ASC')
			->where('parent', $parent)
			->where('modulo', $modulo)
			->findAll();
		// d($processedRow[0]->free_values_object);
		return $processedRow;
	}

	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	protected function getImgFormatiSelect($add_item = ['val' => '', 'nome' => 'Default'])
	{
		$return_data = [];
		$mediaformat_model = new MediaformatModel();
		if ($return_data =  $mediaformat_model->select('folder as val, nome')->asObject()->findAll()) {
			// dd($return_data);
			if ($add_item) {
				$return_data[] = (object) $add_item;
			}
		}
		return $return_data;
	}
	//--------------------------------------------------------------------
	protected function getImgFormati()
	{
		$mediaformat_model = new MediaformatModel();
		return $mediaformat_model->asArray()->findAll();
	}
	//--------------------------------------------------------------------
	public function uploadFile($file_up = null, $nomefile = null, $isImage = FALSE, $curr_file_mime_type = null, $folder =  'uploads')
	{
		$base_folder = WRITEPATH;
		if ($file_up) {
			$not_found = TRUE;
			if ($file_up->isValid() && !$file_up->hasMoved()) {

				if (!$nomefile) {
					$nomefile = $file_up->getRandomName();
				}
				// 
				if (!is_dir(WRITEPATH . $folder)) {
					mkdir(WRITEPATH . $folder, 0755, true);
				}
				$file_up->move(WRITEPATH . '' . $folder, $nomefile);
			}
			if ($isImage != FALSE) {
				$image = \Config\Services::image()->withFile(WRITEPATH . '' . $folder . '/' . $nomefile);
				if (!is_dir(FCPATH . $folder)) {
					mkdir(FCPATH . $folder, 0755, true);
				}
				//
				$return_img_obj = [
					'path' => $nomefile,
					'image_width' => $image->getWidth(),
					'image_height' => $image->getHeight(),
					'formati' => []
				];
				foreach ($this->getImgFormati() as $formato) {
					$this->makeFormato($nomefile, $formato, $folder, $curr_file_mime_type);
					$return_img_obj['formati'][] = [
						'w' => $formato['w'],
						'h' => $formato['h'],
						'path' => $folder . '/' . $formato['folder'] . '/' . $nomefile
					];
				}
				return $return_img_obj;
			} else {
				$file = new \CodeIgniter\Files\File(WRITEPATH . '' . $folder . '/' . $nomefile);
				$file->move(FCPATH . $folder, $nomefile);
				return  ['path' => $nomefile];
			}
		} else {
			return FALSE;
		}
	}
	//--------------------------------------------------------------------
	private function makeFormatoRuleIn($nomefile, $formato, $folder =  'uploads', $curr_file_mime_type = null)
	{

		$maxWidth = $formato['w'];;
		$maxHeight = $formato['h'];;

		// Carica l'immagine originale
		$originalImage = WRITEPATH . '' . $folder . '/' . $nomefile;



		// Identifica il tipo di immagine originale
		$imageInfo = getimagesize($originalImage);
		$imageType = $imageInfo[2];

		// Carica l'immagine in base al tipo
		switch ($imageType) {
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($originalImage);
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($originalImage);
				break;
			case IMAGETYPE_WEBP:
				$image = imagecreatefromwebp($originalImage);
				break;
			default:
				die('Formato immagine non supportato');
		}


		if (!$image) {
			die('Errore nel caricamento dell\'immagine');
		}

		// Ottieni le dimensioni dell'immagine originale
		$width = imagesx($image);
		$height = imagesy($image);

		// Calcola le nuove dimensioni mantenendo l'aspect ratio
		$ratio = $width / $height;
		if ($maxWidth / $maxHeight > $ratio) {
			$thumbnailWidth = $maxHeight * $ratio;
			$thumbnailHeight = $maxHeight;
		} else {
			$thumbnailWidth = $maxWidth;
			$thumbnailHeight = $maxWidth / $ratio;
		}

		// Crea una nuova immagine vuota per il thumbnail
		$thumbnail = imagecreatetruecolor($maxWidth, $maxHeight);

		// Riempie il background del thumbnail con un colore (opzionale, ad esempio bianco)
		$backgroundColor = imagecolorallocate($thumbnail, 255, 255, 255); // Bianco
		imagefill($thumbnail, 0, 0, $backgroundColor);


		// if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_WEBP) {
		// 	imagealphablending($thumbnail, false);
		// 	imagesavealpha($thumbnail, true);
		// 	$backgroundColor = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127); // Trasparente
		// 	imagefill($thumbnail, 0, 0, $backgroundColor);
		// } else {
		// 	// Riempie il background del thumbnail con un colore (bianco) per JPEG
		// 	$backgroundColor = imagecolorallocate($thumbnail, 255, 255, 255);
		// 	imagefill($thumbnail, 0, 0, $backgroundColor);
		// }


		// Calcola la posizione per centrare l'immagine ridimensionata
		$dstX = ($maxWidth - $thumbnailWidth) / 2;
		$dstY = ($maxHeight - $thumbnailHeight) / 2;

		// Ridimensiona l'immagine originale e copia il contenuto scalato sul thumbnail, centrato
		imagecopyresampled(
			$thumbnail,
			$image,
			$dstX,
			$dstY,
			0,
			0,
			$thumbnailWidth,
			$thumbnailHeight,
			$width,
			$height
		);


		// Salva il thumbnail in un file
		$thumbnailImage =  FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $nomefile;

		switch ($imageType) {
			case IMAGETYPE_JPEG:
				imagejpeg($thumbnail, $thumbnailImage, 90); // 90 è la qualità JPEG (0-100)
				break;
			case IMAGETYPE_PNG:
				imagepng($thumbnail, $thumbnailImage, 9); // 0-9 è il livello di compressione PNG
				break;
			case IMAGETYPE_WEBP:
				imagewebp($thumbnail, $thumbnailImage, 90); // 0-100 è la qualità WebP
				break;
		}


		// Libera la memoria
		imagedestroy($image);
		imagedestroy($thumbnail);

		// echo 'Thumbnail creato con successo!';
	}
	//--------------------------------------------------------------------
	protected function makeFormato($nomefile, $formato, $folder =  'uploads', $curr_file_mime_type = null)
	{
		if (trim($formato['folder'])) {
			if (!is_dir(FCPATH . $folder . '/' . $formato['folder'])) {
				mkdir(FCPATH . $folder . '/' . $formato['folder'], 0755, true);
			}
		}
		if (
			($curr_file_mime_type === 'png' || $curr_file_mime_type === 'image/png' || $curr_file_mime_type === 'image/x-png') &&
			$formato['rule'] === '' && $formato['folder'] === ''
		) {
			$file = WRITEPATH . '' . $folder . '/' . $nomefile;
			$newfile = FCPATH . $folder . '/' . $nomefile;
			if (copy($file, $newfile)) {
				return;
			}
		}
		if ($formato['rule'] == 'in') {
			$this->makeFormatoRuleIn($nomefile, $formato, $folder, $curr_file_mime_type);
			return;
		}
		// 
		$image = \Config\Services::image('gd')->withFile(WRITEPATH . '' . $folder . '/' . $nomefile);

		if ($formato['rule'] == 'crop') {
			$image->fit($formato['w'], $formato['h'], 'center');
			$image->crop($formato['w'], $formato['h'], null, null, false, 'auto');
			// } elseif ($formato['rule'] == 'in') {
			// 	$image->resize($formato['w'], $formato['h'], true, 'auto');
			// 	$newX = null;
			// 	$newY = null;
			// 	$newW = $formato['w'];
			// 	$newH = $formato['h'];
			// 	$oldW = $image->getWidth();
			// 	$oldH = $image->getHeight();
			// 	if ($oldW < $newW) {
			// 		$newX = (($newW - $oldW) / 2) * -1;
			// 	}
			// 	if ($oldH < $newH) {
			// 		$newY = (($newH - $oldH) / 2) * -1;
			// 	}
			// 	$image->crop($formato['w'], $formato['h'], $newX, $newY, false, 'auto');
		} elseif ($formato['rule'] == 'fit') {
			$image->fit($formato['w'], $formato['h'], 'center');
		} elseif ($formato['rule'] == 'scale') {
			$image->resize($formato['w'], $formato['h'], true, 'auto');
		} else {
			// $image->resize($image->getWidth(), $image->getHeight(), true, 'auto');
			$image->fit($image->getWidth(), $image->getHeight(), 'center');
		}
		$image->save(FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $nomefile, 75); // 90
		// 
	}
	//--------------------------------------------------------------------
	protected function checkVimeoSetting()
	{
		if (
			env('custom.vimeo_client_id') && trim(env('custom.vimeo_client_id')) &&
			env('custom.vimeo_client_secret') && trim(env('custom.vimeo_client_secret')) &&
			env('custom.vimeo_access_token') && trim(env('custom.vimeo_access_token'))
		) {
			return TRUE;
		}
		return FALSE;
	}
	//--------------------------------------------------------------------
	protected function VimeoClient()
	{
		if ($this->checkVimeoSetting()) {
			return new Vimeo(
				env('custom.vimeo_client_id'),
				env('custom.vimeo_client_secret'),
				env('custom.vimeo_access_token'),
			);
		}
		return FALSE;
	}
}
