<?php

namespace Lc5\Cms\Controllers;

use App\Controllers\BaseController;
use Lc5\Data\Entities\LcUiData;

use Lc5\Data\Models\LanguagesModel;
// use Lc5\Data\Models\CustomFieldsKeysModel;
use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\AppSettingsModel;
use Lc5\Data\Models\ShopSettingsModel;

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

	//--------------------------------------------------------------------
	public function __construct()
	{
		$this->lc_ui_date = new LcUiData();
		// d($this->lc_ui_date);
		$this->req = \Config\Services::request();

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

	//--------------------------------------------------------------------
	protected function getShopSettings()
	{
		// 
		$shop_settings_model = new ShopSettingsModel();
		if (!$shop_settings_entity = $shop_settings_model->where('id_app', $this->getCurrApp())->first()) {
			$this->createBeseShopSettings($this->getCurrApp());
			if (!$shop_settings_entity = $shop_settings_model->where('id_app', $this->getCurrApp())->first()) {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		}
		// 
		return $shop_settings_entity;
	}
	//--------------------------------------------------------------------
	protected function createBeseShopSettings($__id_app = null)
	{
		if (!$__id_app) {
			$__id_app = $this->getCurrApp();
		}

		$shop_settings_model = new ShopSettingsModel();
		$new_base_entity = new \Lc5\Data\Entities\Shopsettings();
		$new_base_entity->id_app = $__id_app;
		$new_base_entity->entity_free_values = '[]';
		$new_base_entity->discount_type = 'PRICE';
		if ($shop_settings_model->save($new_base_entity)) {
			return TRUE;
		}
		return FALSE;
	}

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
		if ($rows_styles_css_data = $rows_style_model->findAll()) {
			foreach ($rows_styles_css_data as $row_style_data) {
				$fields_to_hide = [];
				$entity_fields_conf_byjson = json_decode(($row_style_data->fields_config) ?: '');
				if (json_last_error() === JSON_ERROR_NONE) {
					$fields_to_hide = $entity_fields_conf_byjson->fields;
				}
				foreach ($fields_to_hide as $key => $val) {
					$return_css_code .= "div.card-body[meta-type='$row_style_data->val'] .form-field-" . $row_style_data->type . "_" . $val . "{ display: none !important; } ";
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
	protected function getShopToolsTabs()
	{
		$tabs_data_arr = [
			(object) [
				'label' => 'Config',
				'route' => site_url(route_to('lc_shop_settings')),
				'module_tab' => 'shopsettings',
			],
			(object) [
				'label' => 'Taglie Prodotti',
				'route' => site_url(route_to('lc_shop_prod_sizes')),
				'module_tab' => 'shopproductssizes',
			],
			(object) [
				'label' => 'Varianti Prodotti',
				'route' => site_url(route_to('lc_shop_prod_colors')),
				'module_tab' => 'shopproductscolors',
			],
			(object) [
				'label' => 'Tags Prodotti',
				'route' => site_url(route_to('lc_shop_prod_tags')),
				'module_tab' => 'shopproductstags',
			],
			(object) [
				'label' => 'Aliquote Iva',
				'route' => site_url(route_to('lc_shop_aliquote')),
				'module_tab' => 'shopaliquote',
			]
		];

		return $tabs_data_arr;
	}

	//--------------------------------------------------------------------
	protected function getLcAdminMenu()
	{
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

		if (env('custom.has_shop') === TRUE) {

			// Shop 
			$menu_data_arr['shop'] = (object) [
				'label' => 'Shop',
				'route' => site_url(route_to('lc_shop')),
				'module' => 'shopproduct',
				// 'module' => 'products',
				'ico' => 'basket',
				'items' => [
					(object) [
						'label' => 'Lista Prodotti',
						'route' => site_url(route_to('lc_shop_prod')),
						'module_action' => 'index',
					],
					(object) [
						'label' => 'Nuovo Prodotto',
						'route' => site_url(route_to('lc_shop_prod_new')),
						'module_action' => 'newpost',
					],
					(object) [
						'label' => 'Categorie Prodotti',
						'route' => site_url(route_to('lc_shop_prod_cat')),
						'module_action' => 'shopproductscat',
					],
					(object) [
						'label' => 'Settings',
						'route' => site_url(route_to('lc_shop_settings')),
						'module_action' => 'shopsettings',
					],
					// (object) [
					// 	'label' => 'Taglie Prodotti',
					// 	'route' => site_url(route_to('lc_shop_prod_sizes')),
					// 	'module_action' => 'shopproductssizes',
					// ],
					// (object) [
					// 	'label' => 'Varianti Prodotti',
					// 	'route' => site_url(route_to('lc_shop_prod_colors')),
					// 	'module_action' => 'shopproductscolors',
					// ],
					// (object) [
					// 	'label' => 'Tags Prodotti',
					// 	'route' => site_url(route_to('lc_shop_prod_tags')),
					// 	'module_action' => 'shopproductstags',
					// 	'label' => 'Varianti Prodotti',
					// 	'route' => site_url(route_to('lc_shop_prod_colors')),
					// 	'module_action' => 'shopproductscolors',
					// ],
					// (object) [
					// 	'label' => 'Aliquote Iva',
					// 	'route' => site_url(route_to('lc_shop_aliquote')),
					// 	'module_action' => 'shopaliquote',
					// ]
				]
			];
			// 
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

		if(isset($this->custom_app_modules) && is_array($this->custom_app_modules)){
			foreach($this->custom_app_modules as $cm_key => $custom_modulo_arr){
				$custom_modulo = (object) $custom_modulo_arr;

				// Posts 
				$menu_data_arr['custom_' . $custom_modulo->nome] = (object) [
					'label' => $custom_modulo->nome,
					'route' => site_url(route_to($custom_modulo->lc_base_route)),
					'module' => $cm_key,
					'ico' => 'pin',
					'items' => [
						(object) [
							'label' => 'Lista ',
							'route' => site_url(route_to($custom_modulo->lc_base_route)),
							'module_action' => 'index',
						],
						// (object) [
						// 	'label' => 'New ' . $post_type->nome,
						// 	'route' => site_url(route_to('lc_posts_new', $post_type->val)),
						// 	'module_action' => 'newpost',
						// ],
						// (object) [
						// 	'label' => 'Categorie',
						// 	'route' => site_url(route_to('lc_posts_cat', $post_type->val)),
						// 	'module_action' => 'postscategories',
						// ],
						// (object) [
						// 	'label' => 'Tags',
						// 	'route' => site_url(route_to('lc_posts_tags', $post_type->val)),
						// 	'module_action' => 'poststags',
						// ]
					]
				];
				// 


				// 'corsi' => (object)[
				// 	'nome' => 'Corsi',
				// 	'controller' => 'Corsi',
				// 	'lc_base_route' => 'lc_admin_corsi'
				// ]

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
		$menu_data_arr['users'] = (object) [
			'label' => 'Utenti',
			'route' => site_url(route_to('lc_site_users')),
			'module' => 'siteusers',
			'ico' => 'people',
			'items' => [
				(object) [
					'label' => 'Lista Utenti',
					'route' => site_url(route_to('lc_site_users')),
					'module_action' => 'index',
				],
				(object) [
					'label' => 'Nuovo Utente',
					'route' => site_url(route_to('lc_site_users_new')),
					'module_action' => 'newpost',
				]
			]
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
		return $rows_components_model->findAll();
	}
	//--------------------------------------------------------------------
	protected function getRowColors()
	{
		$rows_colors_model = new RowcolorModel();
		$dati = $rows_colors_model->findAll();
		if ($dati) {
			$dati[] = (object) ['val' => '', 'nome' => 'Nessuno'];
			return $dati;
		}
		return null;
	}
	//--------------------------------------------------------------------
	protected function getRowExtraStyles()
	{
		$rows_extra_styles_model = new RowextrastyleModel();
		$dati = $rows_extra_styles_model->findAll();
		if ($dati) {
			$dati[] = (object) ['val' => '', 'nome' => 'Nessuno'];
			return $dati;
		}
		return null;
	}
	//--------------------------------------------------------------------
	protected function getRowStyles($__type = null)
	{
		$rows_style_model = new RowsstyleModel();
		$qb = $rows_style_model->orderBy('ordine', 'ASC')->orderBy('nome', 'ASC');
		if ($__type) {
			$qb->whereIn('type', [$__type, '']);
		}
		return $qb->findAll();
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
	public function uploadFile($file_up = null, $nomefile = null, $isImage = FALSE, $folder =  'uploads')
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
					$this->makeFormato($nomefile, $formato, $folder);
					// // 
					// $image = \Config\Services::image()->withFile(WRITEPATH . '' . $folder . '/' . $nomefile);
					// if (trim($formato['folder'])) {
					// 	if (!is_dir(FCPATH . $folder . '/' . $formato['folder'])) {
					// 		mkdir(FCPATH . $folder . '/' . $formato['folder'], 0755, true);
					// 	}
					// }
					// if ($formato['rule'] == 'crop') {
					// 	$image->crop($formato['w'], $formato['h'], $x = null, $y = null, false, 'auto');
					// } elseif ($formato['rule'] == 'fit') {
					// 	$image->fit($formato['w'], $formato['h'], $position = 'center');
					// } elseif ($formato['rule'] == 'scale') {
					// 	$image->resize($formato['w'], $formato['h'], true, 'auto');
					// } else {
					// 	// $image->resize($image->getWidth(), $image->getHeight(), true, 'auto');
					// 	$image->fit($image->getWidth(), $image->getHeight(), $position = 'center');

					// }
					// $image->save(FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $nomefile, 90);
					// // 
					$return_img_obj['formati'][] = [
						'w' => $formato['w'],
						'h' => $formato['h'],
						'path' => $folder . '/' . $formato['folder'] . '/' . $nomefile
					];
				}
				// // 
				// if (file_exists(FCPATH . $public_folder . '/' . $nomefile)) {
				// 	unlink(FCPATH . $public_folder . '/' . $nomefile);
				// }
				// // 
				return $return_img_obj;
			} else {
				// $path = $this->request->getFile('userfile')->store('head_img/', 'user_name.jpg');


				$file = new \CodeIgniter\Files\File(WRITEPATH . '' . $folder . '/' . $nomefile);
				// dd($file);
				$file->move(FCPATH . $folder, $nomefile);

				return  ['path' => $nomefile];
			}
		} else {
			return FALSE;
		}
	}
	//--------------------------------------------------------------------
	protected function makeFormato($nomefile, $formato, $folder =  'uploads')
	{
		// 
		$image = \Config\Services::image()->withFile(WRITEPATH . '' . $folder . '/' . $nomefile);
		if (trim($formato['folder'])) {
			if (!is_dir(FCPATH . $folder . '/' . $formato['folder'])) {
				mkdir(FCPATH . $folder . '/' . $formato['folder'], 0755, true);
			}
		}
		if ($formato['rule'] == 'crop') {
			$image->fit($formato['w'], $formato['h'], $position = 'center');
			$image->crop($formato['w'], $formato['h'], $x = null, $y = null, false, 'auto');
		} elseif ($formato['rule'] == 'fit') {
			$image->fit($formato['w'], $formato['h'], $position = 'center');
		} elseif ($formato['rule'] == 'scale') {
			$image->resize($formato['w'], $formato['h'], true, 'auto');
		} else {
			// $image->resize($image->getWidth(), $image->getHeight(), true, 'auto');
			$image->fit($image->getWidth(), $image->getHeight(), $position = 'center');
		}
		$image->save(FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $nomefile, 90);
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
