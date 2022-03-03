<?php 
//----------------------------------------------------------------------------
//------------------- LC
//----------------------------------------------------------------------------

$routes->match(['get', 'post'], 'lc-admin/login', '\Lc5\Cms\Controllers\Admins::login', ['as' => 'lc_login']); //, ['filter' => 'noauth']
$routes->match(['get'], 'lc-admin/logout', '\Lc5\Cms\Controllers\Admins::logout', ['as' => 'lc_logout']); //, ['filter' => 'noauth']

$routes->group('lc-admin', ['namespace' => 'Lc5\Cms\Controllers', 'filter' => 'admin_auth'], function ($routes) {
	$routes->resource('users');
	// $routes->get('dashboard','Dashboard::index', ['as' => 'lc_dashboard']);

	$routes->group('cms-api', function ($routes) {
		
		$routes->match(['get', 'post'], 'video-info', 'Api\CmsApi::getInfoVimeo', ['as' => 'lc_api_video_info_vimeo']);
		$routes->match(['get', 'post'], 'new-tus-video/(:segment)/(:num)', 'Api\CmsApi::newTusVimeo/$1/$2', ['as' => 'lc_api_new_tus_vimeo_w_rel']);
		$routes->match(['get', 'post'], 'new-tus-video', 'Api\CmsApi::newTusVimeo', ['as' => 'lc_api_new_tus_vimeo']);
		$routes->match(['get', 'post'], 'video-delete/(:segment)/(:num)', 'Api\CmsApi::removeVideo/$1/$2', ['as' => 'lc_api_video_delete_vimeo_w_rel']);
		$routes->match(['get', 'post'], 'video-delete', 'Api\CmsApi::removeVideo', ['as' => 'lc_api_video_delete_vimeo']);
	});


	// 

	$routes->group('admin-users', function ($routes) {
		$routes->get('delete/(:num)', 'AdminUsers::delete/$1', ['as' => 'lc_admin_users_delete']);
		$routes->match(['get', 'post'], 'edit/(:num)', 'AdminUsers::edit/$1', ['as' => 'lc_admin_users_edit']);
		$routes->match(['get', 'post'], 'newpost', 'AdminUsers::newpost', ['as' => 'lc_admin_users_new']);
		$routes->get('', 'AdminUsers::index', ['as' => 'lc_admin_users']);
	});
	$routes->group('menus', function ($routes) {
		$routes->get('delete/(:num)', 'Sitemenus::delete/$1', ['as' => 'lc_menus_delete']);
		$routes->match(['get', 'post'], 'edit/(:num)', 'Sitemenus::edit/$1', ['as' => 'lc_menus_edit']);
		$routes->match(['get', 'post'], 'newpost', 'Sitemenus::newpost', ['as' => 'lc_menus_new']);
		$routes->get('', 'Sitemenus::index', ['as' => 'lc_menus']);
	});

	$routes->group('pages', function ($routes) {
		$routes->get('duplicate/(:num)/(:any)', 'Pages::duplicate/$1/$2', ['as' => 'lc_pages_duplicate_lang']);
		$routes->get('duplicate/(:num)', 'Pages::duplicate/$1', ['as' => 'lc_pages_duplicate']);
		$routes->get('delete/(:num)', 'Pages::delete/$1', ['as' => 'lc_pages_delete']);
		$routes->match(['get', 'post'], 'edit/(:num)', 'Pages::edit/$1', ['as' => 'lc_pages_edit']);
		$routes->match(['get', 'post'], 'newpost', 'Pages::newpost', ['as' => 'lc_pages_new']);
		$routes->get('set-as-home/(:num)', 'Pages::setAsHome/$1', ['as' => 'lc_pages_set_as_home']);
		$routes->get('', 'Pages::index', ['as' => 'lc_pages']);
	});
	if (env('custom.has_shop') === TRUE) {

		$routes->group('shop', function ($routes) {
			$routes->group('products', function ($routes) {
				$routes->get('delete/(:num)', 'ShopProducts::delete/$1', ['as' => 'lc_shop_prod_delete']);
				$routes->match(['get', 'post'], 'edit/(:num)', 'ShopProducts::edit/$1', ['as' => 'lc_shop_prod_edit']);
				$routes->match(['get', 'post'], 'newpost/(:num)', 'ShopProducts::newpost/$1', ['as' => 'lc_shop_prod_new_sub']);
				$routes->match(['get', 'post'], 'newpost', 'ShopProducts::newpost', ['as' => 'lc_shop_prod_new']);
				$routes->get('', 'ShopProducts::index', ['as' => 'lc_shop_prod']);
			});
			$routes->group('categories', function ($routes) {
				$routes->get('delete/(:num)', 'ShopProductsCategories::delete/$1', ['as' => 'lc_shop_prod_cat_delete']);
				$routes->match(['get', 'post'], 'edit/(:num)', 'ShopProductsCategories::edit/$1', ['as' => 'lc_shop_prod_cat_edit']);
				$routes->match(['get', 'post'], 'newpost', 'ShopProductsCategories::newpost', ['as' => 'lc_shop_prod_cat_new']);
				$routes->get('', 'ShopProductsCategories::index', ['as' => 'lc_shop_prod_cat']);
			});
			$routes->group('tags', function ($routes) {
				$routes->get('delete/(:num)', 'ShopProductsTags::delete/$1', ['as' => 'lc_shop_prod_tags_delete']);
				$routes->match(['get', 'post'], 'combo-newpost', 'ShopProductsTags::ajaxCreate', ['as' => 'lc_shop_prod_tags_data_new']);
				$routes->match(['get', 'post'], 'edit/(:num)', 'ShopProductsTags::edit/$1', ['as' => 'lc_shop_prod_tags_edit']);
				$routes->match(['get', 'post'], 'newpost', 'ShopProductsTags::newpost', ['as' => 'lc_shop_prod_tags_new']);
				$routes->get('', 'ShopProductsTags::index', ['as' => 'lc_shop_prod_tags']);
			});
			$routes->group('taglie', function ($routes) {
				$routes->get('delete/(:num)', 'ShopProductsSizes::delete/$1', ['as' => 'lc_shop_prod_sizes_delete']);
				$routes->match(['get', 'post'], 'combo-newpost', 'ShopProductsSizes::ajaxCreate', ['as' => 'lc_shop_prod_sizes_data_new']);
				$routes->match(['get', 'post'], 'edit/(:num)', 'ShopProductsSizes::edit/$1', ['as' => 'lc_shop_prod_sizes_edit']);
				$routes->match(['get', 'post'], 'newpost', 'ShopProductsSizes::newpost', ['as' => 'lc_shop_prod_sizes_new']);
				$routes->get('', 'ShopProductsSizes::index', ['as' => 'lc_shop_prod_sizes']);
			});
			$routes->group('colori', function ($routes) {
				$routes->get('delete/(:num)', 'ShopProductsColors::delete/$1', ['as' => 'lc_shop_prod_colors_delete']);
				$routes->match(['get', 'post'], 'combo-newpost', 'ShopProductsColors::ajaxCreate', ['as' => 'lc_shop_prod_colors_data_new']);
				$routes->match(['get', 'post'], 'edit/(:num)', 'ShopProductsColors::edit/$1', ['as' => 'lc_shop_prod_colors_edit']);
				$routes->match(['get', 'post'], 'newpost', 'ShopProductsColors::newpost', ['as' => 'lc_shop_prod_colors_new']);
				$routes->get('', 'ShopProductsColors::index', ['as' => 'lc_shop_prod_colors']);
			});
			$routes->group('aliquote-iva', function ($routes) {
				$routes->get('delete/(:num)', 'ShopAliquote::delete/$1', ['as' => 'lc_shop_aliquote_delete']);
				$routes->match(['get', 'post'], 'edit/(:num)', 'ShopAliquote::edit/$1', ['as' => 'lc_shop_aliquote_edit']);
				$routes->match(['get', 'post'], 'newpost', 'ShopAliquote::newpost', ['as' => 'lc_shop_aliquote_new']);
				$routes->get('', 'ShopAliquote::index', ['as' => 'lc_shop_aliquote']);
			});

			$routes->match(['get', 'post'], 'settings', 'ShopSettings::edit', ['as' => 'lc_shop_settings']); //, ['filter' => 'noauth']

			// $routes->get('(:any)/delete/(:num)', 'Posts::delete/$1/$2', ['as' => 'lc_posts_delete']);
			// $routes->match(['get', 'post'], '(:any)/edit/(:num)', 'Posts::edit/$1/$2', ['as' => 'lc_posts_edit']);
			// $routes->match(['get', 'post'], '(:any)/newpost', 'Posts::newpost/$1', ['as' => 'lc_posts_new']);
			// $routes->get('(:any)', 'Posts::index/$1', ['as' => 'lc_posts']);
		});
	}

	$routes->group('posts', function ($routes) {
		$routes->group('tags', function ($routes) {
			// $routes->get('', 'PostsTags::index', ['as' => 'lc_posts_tags_all']);

			$routes->get('(:any)/delete/(:num)', 'PostsTags::delete/$1/$2', ['as' => 'lc_posts_tags_delete']);
			$routes->match(['get', 'post'], '(:any)/edit/(:num)', 'PostsTags::edit/$1/$2', ['as' => 'lc_posts_tags_edit']);
			$routes->match(['get', 'post'], '(:any)/newpost', 'PostsTags::newpost/$1', ['as' => 'lc_posts_tags_new']);
			$routes->match(['get', 'post'], '(:any)/combo-newpost', 'PostsTags::ajaxCreate/$1', ['as' => 'lc_posts_tags_data_new']);
			$routes->get('data/list/(:any)', 'PostsTags::dataList/$1', ['as' => 'lc_posts_tags_data_list']);
			$routes->get('(:any)', 'PostsTags::index/$1', ['as' => 'lc_posts_tags']);
		});
		$routes->group('categories', function ($routes) {
			$routes->get('(:any)/delete/(:num)', 'PostsCategories::delete/$1/$2', ['as' => 'lc_posts_cat_delete']);
			$routes->match(['get', 'post'], '(:any)/edit/(:num)', 'PostsCategories::edit/$1/$2', ['as' => 'lc_posts_cat_edit']);
			$routes->match(['get', 'post'], '(:any)/newpost', 'PostsCategories::newpost/$1', ['as' => 'lc_posts_cat_new']);
			$routes->get('(:any)', 'PostsCategories::index/$1', ['as' => 'lc_posts_cat']);
		});
		$routes->get('(:any)/duplicate/(:num)/(:any)', 'Posts::duplicate/$1/$2/$3', ['as' => 'lc_posts_duplicate_lang']);
		$routes->get('(:any)/duplicate/(:num)', 'Posts::duplicate/$1/$2', ['as' => 'lc_posts_duplicate']);
		$routes->get('(:any)/delete/(:num)', 'Posts::delete/$1/$2', ['as' => 'lc_posts_delete']);
		$routes->match(['get', 'post'], '(:any)/edit/(:num)', 'Posts::edit/$1/$2', ['as' => 'lc_posts_edit']);
		$routes->match(['get', 'post'], '(:any)/newpost', 'Posts::newpost/$1', ['as' => 'lc_posts_new']);
		$routes->get('(:any)', 'Posts::index/$1', ['as' => 'lc_posts']);
	});

	$routes->group('tools', function ($routes) {
		// 
		$routes->group('posts-type', function ($routes) {
			$routes->get('delete/(:num)', 'Poststypes::delete/$1', ['as' => 'lc_tools_poststypes_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Poststypes::edit/$1', ['as' => 'lc_tools_poststypes_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Poststypes::newpost', ['as' => 'lc_tools_poststypes_new']);
			$routes->get('', 'Poststypes::index', ['as' => 'lc_tools_poststypes']);
		});
		// 

		$routes->group('pages-type', function ($routes) {
			$routes->get('delete/(:num)', 'Pagestype::delete/$1', ['as' => 'lc_tools_pagetypes_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Pagestype::edit/$1', ['as' => 'lc_tools_pagetypes_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Pagestype::newpost', ['as' => 'lc_tools_pagetypes_new']);
			$routes->get('', 'Pagestype::index', ['as' => 'lc_tools_pagetypes']);
		});
		$routes->group('row-style', function ($routes) {
			$routes->get('delete/(:num)', 'Rowsstyle::delete/$1', ['as' => 'lc_tools_rows_styles_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Rowsstyle::edit/$1', ['as' => 'lc_tools_rows_styles_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Rowsstyle::newpost', ['as' => 'lc_tools_rows_styles_new']);
			$routes->get('', 'Rowsstyle::index', ['as' => 'lc_tools_rows_styles']);
		});
		$routes->group('row-colors', function ($routes) {
			$routes->get('delete/(:num)', 'Rowscolor::delete/$1', ['as' => 'lc_tools_rows_colors_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Rowscolor::edit/$1', ['as' => 'lc_tools_rows_colors_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Rowscolor::newpost', ['as' => 'lc_tools_rows_colors_new']);
			$routes->get('', 'Rowscolor::index', ['as' => 'lc_tools_rows_colors']);
		});
		$routes->group('row-extra-styles', function ($routes) {
			$routes->get('delete/(:num)', 'RowExtraStyles::delete/$1', ['as' => 'lc_tools_rows_extra_styles_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'RowExtraStyles::edit/$1', ['as' => 'lc_tools_rows_extra_styles_edit']);
			$routes->match(['get', 'post'], 'newpost', 'RowExtraStyles::newpost', ['as' => 'lc_tools_rows_extra_styles_new']);
			$routes->get('', 'RowExtraStyles::index', ['as' => 'lc_tools_rows_extra_styles']);
		});
		$routes->group('components', function ($routes) {
			$routes->get('delete/(:num)', 'Rowcomponent::delete/$1', ['as' => 'lc_tools_rows_componet_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Rowcomponent::edit/$1', ['as' => 'lc_tools_rows_componet_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Rowcomponent::newpost', ['as' => 'lc_tools_rows_componet_new']);
			$routes->get('', 'Rowcomponent::index', ['as' => 'lc_tools_rows_componet']);
		});
		$routes->group('custom-fields-keys', function ($routes) {
			$routes->get('delete/(:num)', 'CustomFieldsKeys::delete/$1', ['as' => 'lc_tools_custom_fields_keys_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'CustomFieldsKeys::edit/$1', ['as' => 'lc_tools_custom_fields_keys_edit']);
			$routes->match(['get', 'post'], 'newpost', 'CustomFieldsKeys::newpost', ['as' => 'lc_tools_custom_fields_keys_new']);
			$routes->get('', 'CustomFieldsKeys::index', ['as' => 'lc_tools_custom_fields_keys']);
		});
		// // 
		// $routes->group('labels', function ($routes) {
		// 	$routes->get('duplicate/(:num)/(:any)', 'LcLabels::duplicate/$1/$2/$3', ['as' => 'lc_labels_duplicate_lang']);
		// 	$routes->get('duplicate/(:num)', 'LcLabels::duplicate/$1/$2', ['as' => 'lc_labels_duplicate']);
		// 	$routes->get('delete/(:num)', 'LcLabels::delete/$1', ['as' => 'lc_labels_delete']);
		// 	$routes->match(['get', 'post'], 'edit/(:num)', 'LcLabels::edit/$1', ['as' => 'lc_labels_edit']);
		// 	$routes->match(['get', 'post'], 'newpost', 'LcLabels::newpost', ['as' => 'lc_labels_new']);
		// 	$routes->get('', 'LcLabels::index', ['as' => 'lc_labels']);
		// });
		// // 
		$routes->group('languages', function ($routes) {
			$routes->get('delete/(:num)', 'Language::delete/$1', ['as' => 'lc_languages_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Language::edit/$1', ['as' => 'lc_languages_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Language::newpost', ['as' => 'lc_languages_new']);
			$routes->get('', 'Language::index', ['as' => 'lc_languages']);
		});
		// 
		$routes->group('apps', function ($routes) {
			// $routes->get( 'delete/(:num)', 'Lcapps::delete/$1', ['as' => 'lc_apps_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Lcapps::edit/$1', ['as' => 'lc_apps_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Lcapps::newpost', ['as' => 'lc_apps_new']);
			$routes->get('', 'Lcapps::index', ['as' => 'lc_apps']);
		});
		// 
		// 
		$routes->match(['get', 'post'], 'db-table-structure/(:any)', 'Migrate::tableStructure/$1', ['as' => 'lc_table_structure']);
		$routes->match(['get', 'post'], 'db-table-structure', 'Migrate::tableStructure', ['as' => 'lc_tables_structure']);

		
		// 
		// 
	});
	$routes->match(['get', 'post'], 'settings', 'AppSettings::edit', ['as' => 'lc_app_settings']); //, ['filter' => 'noauth']


	$routes->group('media', function ($routes) {
		$routes->group('formati', function ($routes) {
			$routes->get('delete/(:num)', 'Mediaformat::delete/$1', ['as' => 'lc_media_formati_delete']);
			$routes->match(['get', 'post'], 'edit/(:num)', 'Mediaformat::edit/$1', ['as' => 'lc_media_formati_edit']);
			$routes->match(['get', 'post'], 'newpost', 'Mediaformat::newpost', ['as' => 'lc_media_formati_new']);
			$routes->get('', 'Mediaformat::index', ['as' => 'lc_media_formati']);
		});
		$routes->get('delete/(:num)', 'Media::delete/$1', ['as' => 'lc_media_delete']);
		$routes->match(['get'], 'getoriginal/(:num)', 'Media::getOriginal/$1', ['as' => 'lc_media_original']);
		$routes->match(['get', 'post'], 'rebase-all/(:num)', 'Media::rigeneraAllFormati/$1', ['as' => 'lc_media_rebase_all']);
		$routes->match(['get', 'post'], 'rebase/(:num)/(:num)', 'Media::rigeneraFormato/$1/$2', ['as' => 'lc_media_rebase']);
		$routes->match(['get', 'post'], 'rotete/(:num)/(:num)', 'Media::rotate/$1/$2', ['as' => 'lc_media_rotate']);
		$routes->match(['get', 'post'], 'crop/(:num)/(:num)', 'Media::crop/$1/$2', ['as' => 'lc_media_crop']);
		$routes->match(['get', 'post'], 'edit/(:num)', 'Media::edit/$1', ['as' => 'lc_media_edit']);
		$routes->match(['get', 'post'], 'newpost', 'Media::newpost', ['as' => 'lc_media_new']);
		$routes->match(['get', 'post'], 'ajax-upload', 'Media::ajaxUpload', ['as' => 'lc_media_ajax_upload']);
		$routes->get('ajax-list', 'Media::ajaxList', ['as' => 'lc_media_ajax_list']);
		$routes->get('', 'Media::index', ['as' => 'lc_media']);
	});
	$routes->get('/', 'Dashboard::index');
	$routes->get('change-lang/(:any)', 'MasterLc::cambiaLang/$1', ['as' => 'lc_cambia_lang']);
	$routes->get('change-app/(:any)', 'MasterLc::cambiaApp/$1', ['as' => 'lc_cambia_app']);
	$routes->get('', 'Dashboard::index', ['as' => 'lc_dashboard']);
	$routes->get('', 'Dashboard::index', ['as' => 'lc_root']);
});

//----------------------------------------------------------------------------
//------------------- FINE LC
//----------------------------------------------------------------------------
