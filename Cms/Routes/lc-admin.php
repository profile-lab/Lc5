<?php
//----------------------------------------------------------------------------
//------------------- LC
//----------------------------------------------------------------------------

if (env('custom.hide_lc_cms') === TRUE) {
} else {

	$routes->match(['GET', 'POST'], 'lc-admin/login', '\Lc5\Cms\Controllers\Admins::login', ['as' => 'lc_login']); //, ['filter' => 'noauth']
	$routes->match(['GET'], 'lc-admin/logout', '\Lc5\Cms\Controllers\Admins::logout', ['as' => 'lc_logout']); //, ['filter' => 'noauth']

	$routes->group('lc-admin', ['namespace' => 'Lc5\Cms\Controllers', 'filter' => 'admin_auth'], function ($routes) {
		$routes->resource('users');
		// $routes->get('dashboard','Dashboard::index', ['as' => 'lc_dashboard']);

		$routes->group('cms-api', function ($routes) {

			$routes->match(['GET', 'POST'], 'video-info', 'Api\CmsApi::getInfoVimeo', ['as' => 'lc_api_video_info_vimeo']);
			$routes->match(['GET', 'POST'], 'new-tus-video/(:segment)/(:num)', 'Api\CmsApi::newTusVimeo/$1/$2', ['as' => 'lc_api_new_tus_vimeo_w_rel']);
			$routes->match(['GET', 'POST'], 'new-video-by-url/(:segment)/(:num)', 'Api\CmsApi::newVideoByUrl/$1/$2', ['as' => 'lc_api_new_vimeo_by_url']);
			$routes->match(['GET', 'POST'], 'new-tus-video', 'Api\CmsApi::newTusVimeo', ['as' => 'lc_api_new_tus_vimeo']);
			$routes->match(['GET', 'POST'], 'video-delete/(:segment)/(:num)', 'Api\CmsApi::removeVideo/$1/$2', ['as' => 'lc_api_video_delete_vimeo_w_rel']);
			$routes->match(['GET', 'POST'], 'video-delete', 'Api\CmsApi::removeVideo', ['as' => 'lc_api_video_delete_vimeo']);
		});


		// 

		$routes->group('admin-users', function ($routes) {
			$routes->get('delete/(:num)', 'AdminUsers::delete/$1', ['as' => 'lc_admin_users_delete']);
			$routes->match(['GET', 'POST'], 'edit/(:num)', 'AdminUsers::edit/$1', ['as' => 'lc_admin_users_edit']);
			$routes->match(['GET', 'POST'], 'newpost', 'AdminUsers::newpost', ['as' => 'lc_admin_users_new']);
			$routes->get('', 'AdminUsers::index', ['as' => 'lc_admin_users']);
		});
		
		$routes->group('menus', function ($routes) {
			$routes->get('delete/(:num)', 'Sitemenus::delete/$1', ['as' => 'lc_menus_delete']);
			$routes->match(['GET', 'POST'], 'edit/(:num)', 'Sitemenus::edit/$1', ['as' => 'lc_menus_edit']);
			$routes->match(['GET', 'POST'], 'newpost', 'Sitemenus::newpost', ['as' => 'lc_menus_new']);
			$routes->get('', 'Sitemenus::index', ['as' => 'lc_menus']);
		});

		$routes->group('pages', function ($routes) {
			$routes->get('duplicate/(:num)/(:any)', 'Pages::duplicate/$1/$2', ['as' => 'lc_pages_duplicate_lang']);
			$routes->get('duplicate/(:num)', 'Pages::duplicate/$1', ['as' => 'lc_pages_duplicate']);
			$routes->get('delete/(:num)', 'Pages::delete/$1', ['as' => 'lc_pages_delete']);
			$routes->match(['GET', 'POST'], 'edit/(:num)', 'Pages::edit/$1', ['as' => 'lc_pages_edit']);
			$routes->match(['GET', 'POST'], 'newpost', 'Pages::newpost', ['as' => 'lc_pages_new']);
			$routes->get('set-as-home/(:num)', 'Pages::setAsHome/$1', ['as' => 'lc_pages_set_as_home']);
			$routes->get('', 'Pages::index', ['as' => 'lc_pages']);
		});


		$routes->group('posts', function ($routes) {
			$routes->group('tags', function ($routes) {
				// $routes->get('', 'PostsTags::index', ['as' => 'lc_posts_tags_all']);

				$routes->get('(:any)/delete/(:num)', 'PostsTags::delete/$1/$2', ['as' => 'lc_posts_tags_delete']);
				$routes->match(['GET', 'POST'], '(:any)/edit/(:num)', 'PostsTags::edit/$1/$2', ['as' => 'lc_posts_tags_edit']);
				$routes->match(['GET', 'POST'], '(:any)/newpost', 'PostsTags::newpost/$1', ['as' => 'lc_posts_tags_new']);
				$routes->match(['GET', 'POST'], '(:any)/combo-newpost', 'PostsTags::ajaxCreate/$1', ['as' => 'lc_posts_tags_data_new']);
				$routes->get('data/list/(:any)', 'PostsTags::dataList/$1', ['as' => 'lc_posts_tags_data_list']);
				$routes->get('(:any)', 'PostsTags::index/$1', ['as' => 'lc_posts_tags']);
			});
			$routes->group('categories', function ($routes) {
				$routes->get('(:any)/delete/(:num)', 'PostsCategories::delete/$1/$2', ['as' => 'lc_posts_cat_delete']);
				$routes->match(['GET', 'POST'], '(:any)/edit/(:num)', 'PostsCategories::edit/$1/$2', ['as' => 'lc_posts_cat_edit']);
				$routes->match(['GET', 'POST'], '(:any)/newpost', 'PostsCategories::newpost/$1', ['as' => 'lc_posts_cat_new']);
				$routes->get('(:any)', 'PostsCategories::index/$1', ['as' => 'lc_posts_cat']);
			});
			$routes->get('(:any)/duplicate/(:num)/(:any)', 'Posts::duplicate/$1/$2/$3', ['as' => 'lc_posts_duplicate_lang']);
			$routes->get('(:any)/duplicate/(:num)', 'Posts::duplicate/$1/$2', ['as' => 'lc_posts_duplicate']);
			$routes->get('(:any)/delete/(:num)', 'Posts::delete/$1/$2', ['as' => 'lc_posts_delete']);
			$routes->match(['GET', 'POST'], '(:any)/edit/(:num)', 'Posts::edit/$1/$2', ['as' => 'lc_posts_edit']);
			$routes->match(['GET', 'POST'], '(:any)/newpost', 'Posts::newpost/$1', ['as' => 'lc_posts_new']);
			$routes->get('(:any)', 'Posts::index/$1', ['as' => 'lc_posts']);
		});

		$routes->group('tools', function ($routes) {
			// 
			$routes->group('posts-type', function ($routes) {
				$routes->get('delete/(:num)', 'Poststypes::delete/$1', ['as' => 'lc_tools_poststypes_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Poststypes::edit/$1', ['as' => 'lc_tools_poststypes_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Poststypes::newpost', ['as' => 'lc_tools_poststypes_new']);
				$routes->get('', 'Poststypes::index', ['as' => 'lc_tools_poststypes']);
			});
			// 

			$routes->group('pages-type', function ($routes) {
				$routes->get('delete/(:num)', 'Pagestype::delete/$1', ['as' => 'lc_tools_pagetypes_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Pagestype::edit/$1', ['as' => 'lc_tools_pagetypes_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Pagestype::newpost', ['as' => 'lc_tools_pagetypes_new']);
				$routes->get('', 'Pagestype::index', ['as' => 'lc_tools_pagetypes']);
			});
			$routes->group('row-style', function ($routes) {
				$routes->get('delete/(:num)', 'Rowsstyle::delete/$1', ['as' => 'lc_tools_rows_styles_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Rowsstyle::edit/$1', ['as' => 'lc_tools_rows_styles_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Rowsstyle::newpost', ['as' => 'lc_tools_rows_styles_new']);
				$routes->get('', 'Rowsstyle::index', ['as' => 'lc_tools_rows_styles']);
			});
			$routes->group('row-colors', function ($routes) {
				$routes->get('delete/(:num)', 'Rowscolor::delete/$1', ['as' => 'lc_tools_rows_colors_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Rowscolor::edit/$1', ['as' => 'lc_tools_rows_colors_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Rowscolor::newpost', ['as' => 'lc_tools_rows_colors_new']);
				$routes->get('', 'Rowscolor::index', ['as' => 'lc_tools_rows_colors']);
			});
			$routes->group('row-extra-styles', function ($routes) {
				$routes->get('delete/(:num)', 'RowExtraStyles::delete/$1', ['as' => 'lc_tools_rows_extra_styles_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'RowExtraStyles::edit/$1', ['as' => 'lc_tools_rows_extra_styles_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'RowExtraStyles::newpost', ['as' => 'lc_tools_rows_extra_styles_new']);
				$routes->get('', 'RowExtraStyles::index', ['as' => 'lc_tools_rows_extra_styles']);
			});
			$routes->group('components', function ($routes) {
				$routes->get('delete/(:num)', 'Rowcomponent::delete/$1', ['as' => 'lc_tools_rows_componet_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Rowcomponent::edit/$1', ['as' => 'lc_tools_rows_componet_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Rowcomponent::newpost', ['as' => 'lc_tools_rows_componet_new']);
				$routes->get('', 'Rowcomponent::index', ['as' => 'lc_tools_rows_componet']);
			});
			$routes->group('custom-fields-keys', function ($routes) {
				$routes->get('delete/(:num)', 'CustomFieldsKeys::delete/$1', ['as' => 'lc_tools_custom_fields_keys_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'CustomFieldsKeys::edit/$1', ['as' => 'lc_tools_custom_fields_keys_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'CustomFieldsKeys::newpost', ['as' => 'lc_tools_custom_fields_keys_new']);
				$routes->get('', 'CustomFieldsKeys::index', ['as' => 'lc_tools_custom_fields_keys']);
			});
			// // 
			// $routes->group('labels', function ($routes) {
			// 	$routes->get('duplicate/(:num)/(:any)', 'LcLabels::duplicate/$1/$2/$3', ['as' => 'lc_labels_duplicate_lang']);
			// 	$routes->get('duplicate/(:num)', 'LcLabels::duplicate/$1/$2', ['as' => 'lc_labels_duplicate']);
			// 	$routes->get('delete/(:num)', 'LcLabels::delete/$1', ['as' => 'lc_labels_delete']);
			// 	$routes->match(['GET', 'POST'], 'edit/(:num)', 'LcLabels::edit/$1', ['as' => 'lc_labels_edit']);
			// 	$routes->match(['GET', 'POST'], 'newpost', 'LcLabels::newpost', ['as' => 'lc_labels_new']);
			// 	$routes->get('', 'LcLabels::index', ['as' => 'lc_labels']);
			// });
			// // 
			$routes->group('languages', function ($routes) {
				$routes->get('delete/(:num)', 'Language::delete/$1', ['as' => 'lc_languages_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Language::edit/$1', ['as' => 'lc_languages_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Language::newpost', ['as' => 'lc_languages_new']);
				$routes->get('', 'Language::index', ['as' => 'lc_languages']);
			});
			// 
			$routes->group('apps', function ($routes) {
				// $routes->get( 'delete/(:num)', 'Lcapps::delete/$1', ['as' => 'lc_apps_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Lcapps::edit/$1', ['as' => 'lc_apps_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Lcapps::newpost', ['as' => 'lc_apps_new']);
				$routes->get('', 'Lcapps::index', ['as' => 'lc_apps']);
			});
			// 
			$routes->group('lc-tools', function ($routes) {
				// // $routes->get( 'delete/(:num)', 'Lcapps::delete/$1', ['as' => 'lc_apps_delete']);
				// $routes->match(['GET', 'POST'], 'edit/(:num)', 'Lcapps::edit/$1', ['as' => 'lc_apps_edit']);
				// $routes->match(['GET', 'POST'], 'newpost', 'Lcapps::newpost', ['as' => 'lc_apps_new']);

				$routes->group('db', function ($routes) {
					$routes->add('dump',  'LcTools::dbDump', ['as' => 'lc_tools_db_dump']);
					$routes->add('elimina/(:any)/(:any)',  'LcTools::eliminaSingleDumpFiles/$1/$2', ['as' => 'lc_tools_db_dump_delete_item']);
					$routes->add('downloads/(:any)/(:any)',  'LcTools::scaricaSingleBumpFiles/$1/$2', ['as' => 'lc_tools_db_dump_download_item']);
					$routes->add('zippa/(:any)/(:any)',  'LcTools::comprimiSingleDumpFiles/$1/$2', ['as' => 'lc_tools_db_dump_zip']);
					$routes->add('',  'LcTools::dbIndex', ['as' => 'lc_tools_db']);
				});
				$routes->group('files', function ($routes) {
					$routes->add('elimina/(:any)',  'LcTools::uploadFilesBkpDelete/$1', ['as' => 'lc_tools_uploadfiles_delete_item']);
					$routes->add('downloads/(:any)',  'LcTools::uploadFilesBkpDownload/$1', ['as' => 'lc_tools_uploadfiles_download_item']);
					$routes->add('create',  'LcTools::uploadFilesBkpCreate', ['as' => 'lc_tools_uploadfiles_create']);
					$routes->add('',  'LcTools::uploadFilesBkpIndex', ['as' => 'lc_tools_uploadfiles']);
				});
				$routes->group('file-formats', function ($routes) {
					$routes->add('export',  'LcTools::fileFormatsExport', ['as' => 'lc_tools_file_format_export']);
					$routes->add('elimina/(:any)/(:any)',  'LcTools::fileFormatsElimina/$1/$2', ['as' => 'lc_tools_file_format_export_delete_item']);
					$routes->add('downloads/(:any)/(:any)',  'LcTools::fileFormatsScarica/$1/$2', ['as' => 'lc_tools_file_format_export_download_item']);
					$routes->add('import/(:any)',  'LcTools::fileFormatsImport/$1', ['as' => 'lc_tools_file_format_export_import']);
					$routes->add('',  'LcTools::fileFormats', ['as' => 'lc_tools_file_format']);
				});
				$routes->group('pages-structure', function ($routes) {
					$routes->add('export',  'LcTools::pagesStructureExport', ['as' => 'lc_tools_page_structure_export']);
					$routes->add('elimina/(:any)/(:any)',  'LcTools::pagesStructureElimina/$1/$2', ['as' => 'lc_tools_page_structure_export_delete_item']);
					$routes->add('downloads/(:any)/(:any)',  'LcTools::pagesStructureScarica/$1/$2', ['as' => 'lc_tools_page_structure_export_download_item']);
					$routes->add('import/(:any)',  'LcTools::pagesStructureImport/$1', ['as' => 'lc_tools_page_structure_export_import']);
					$routes->add('',  'LcTools::pagesStructure', ['as' => 'lc_tools_page_structure']);
				});




				$routes->get('', 'LcTools::index', ['as' => 'lc_tools_index']);
			});
			// 
			// 
			$routes->match(['GET', 'POST'], 'db-table-structure/(:any)', 'Migrate::tableStructure/$1', ['as' => 'lc_table_structure']);
			$routes->match(['GET', 'POST'], 'db-table-structure', 'Migrate::tableStructure', ['as' => 'lc_tables_structure']);


			// 
			// 
		});
		$routes->match(['GET', 'POST'], 'settings', 'AppSettings::edit', ['as' => 'lc_app_settings']); //, ['filter' => 'noauth']


		$routes->group('media', function ($routes) {
			$routes->group('cestino', function ($routes) {
				$routes->get('delete-file/(:num)', 'MediaTrash::deleteFile/$1', ['as' => 'lc_media_cestino_delete_file']);
				$routes->get('delete-all-files', 'MediaTrash::deleteAllFiles', ['as' => 'lc_media_cestino_delete_all_files']);
				$routes->get('', 'MediaTrash::index', ['as' => 'lc_media_cestino']);
			});
			$routes->group('formati', function ($routes) {
				$routes->get('delete/(:num)', 'Mediaformat::delete/$1', ['as' => 'lc_media_formati_delete']);
				$routes->match(['GET', 'POST'], 'edit/(:num)', 'Mediaformat::edit/$1', ['as' => 'lc_media_formati_edit']);
				$routes->match(['GET', 'POST'], 'newpost', 'Mediaformat::newpost', ['as' => 'lc_media_formati_new']);
				$routes->get('', 'Mediaformat::index', ['as' => 'lc_media_formati']);
				$routes->match(['GET', 'POST'], 'rebase-all-images/(:num)', 'Media::rigeneraAllImagesInFormatoFormato/$1', ['as' => 'lc_media_formati_rebase_all_images_in_format']);
			});
			$routes->get('delete/(:num)', 'Media::delete/$1', ['as' => 'lc_media_delete']);
			$routes->match(['GET'], 'getoriginal/(:num)', 'Media::getOriginal/$1', ['as' => 'lc_media_original']);
			$routes->match(['GET', 'POST'], 'rebase-all/(:num)', 'Media::rigeneraAllFormati/$1', ['as' => 'lc_media_rebase_all']);
			$routes->match(['GET', 'POST'], 'rebase/(:num)/(:num)', 'Media::rigeneraFormato/$1/$2', ['as' => 'lc_media_rebase']);
			$routes->match(['GET', 'POST'], 'rotete/(:num)/(:num)', 'Media::rotate/$1/$2', ['as' => 'lc_media_rotate']);
			$routes->match(['GET', 'POST'], 'crop/(:num)/(:num)', 'Media::crop/$1/$2', ['as' => 'lc_media_crop']);
			$routes->match(['GET', 'POST'], 'edit/(:num)', 'Media::edit/$1', ['as' => 'lc_media_edit']);
			$routes->match(['GET', 'POST'], 'newpost', 'Media::newpost', ['as' => 'lc_media_new']);
			$routes->match(['GET', 'POST'], 'ajax-upload', 'Media::ajaxUpload', ['as' => 'lc_media_ajax_upload']);
			$routes->get('ajax-list', 'Media::ajaxList', ['as' => 'lc_media_ajax_list']);
			$routes->get('', 'Media::index', ['as' => 'lc_media']);
		});
		$routes->get('/', 'Dashboard::index', ['as' => 'lc_dashboard']);
		$routes->get('change-lang/(:any)', 'MasterLc::cambiaLang/$1', ['as' => 'lc_cambia_lang']);
		$routes->get('change-app/(:any)', 'MasterLc::cambiaApp/$1', ['as' => 'lc_cambia_app']);
		$routes->get('', 'Dashboard::index'); //, ['as' => 'lc_dashboard']
		$routes->get('', 'Dashboard::index', ['as' => 'lc_root']);
	});
}



//----------------------------------------------------------------------------
//------------------- FINE LC
//----------------------------------------------------------------------------
