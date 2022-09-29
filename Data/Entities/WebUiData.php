<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;
use Config\Services;
use Lc5\Data\Models\MenusModel;
use Lc5\Data\Models\LanguagesModel;
use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\AppSettingsModel;
use stdClass;

class WebUiData extends Entity
{
    public function __construct()
	{
        
        parent::__construct();
      
        if(! defined('__web_app_id__')){
            throw new \CodeIgniter\Exceptions\ConfigException();
            throw new \Exception("APP NON TROVATA");

        }
        $app = new stdClass();
		$lcapps_model = new LcappsModel();
	    if(!$app_base_data = $lcapps_model->asObject()->find(__web_app_id__)){
            throw new \Exception("Nessuna informazione relativa all'app selezionata è stata trovata nel database.");
        }	
        // 
        $app_settings_model = new AppSettingsModel();
        // ->select('address, app_claim, app_description, copy, email, entity_free_values, facebook, instagram, maps, phone, piva, seo_title, shop, twitter')
        if (!$app_settings = $app_settings_model->asObject()->where('id_app', $app_base_data->id)->where('lang', __locale__)->first()) {
            throw new \Exception("App settings not found.");
        }
        unset($app_settings->id);
        unset($app_settings->lang);
        unset($app_settings->created_at);
        unset($app_settings->updated_at);

        $app = (object) array_merge((array) $app_base_data, (array) $app_settings);


        // d($app_base_data);
        // d($app_settings);
        // dd($app);
        
    
        // 
        // 
		$menus_model = new MenusModel();
        $menus_arr = [];
		if ($menus = $menus_model->findAll()){
            foreach($menus as $menu){
                $menu_guid = url_title($menu->nome, '-', TRUE);
                $menus_arr[$menu_guid] = (object) [ 'id' => $menu->id, 'guid' => $menu_guid, 'nome' => $menu->nome, 'data' => json_decode( $menu->json_data) ];
            }
        }
        //
        $menu_lang = [];
		$languages_model = new LanguagesModel();
        if ($langs = $languages_model->asObject()->findAll()){
            foreach($langs as $lang){
                $_lang = [];
                $_lang['id'] =  trim($lang->val);
                $_lang['label'] =  $lang->nome;
                $_lang['label_mini'] =  $lang->val;
                $_lang['parameter'] =  '/'.$lang->val;
                $_lang['is_current'] = ($lang->val == __locale__) ;
                $_lang['is_default'] =  false;
                if($lang->val == __default_locale__){
                    $_lang['parameter'] =  '/';
                    $_lang['is_default'] =  true;
                }
                $menu_lang[] = (object) $_lang;
            }
        }
        
      
        $base_attributes = [
            'app' => $app,
            //
            'web_user_id' => session()->get('user_id'),
            'web_user_data' => session()->get('user_data'),
            'web_user_isLoggedIn' => session()->get('isUserLoggedIn'),
            // 
            'site_menus' => $menus_arr,
            'lang_menu' => $menu_lang,
            //
        ];
        if (env('custom.has_shop') === TRUE) {
            $cart = Services::shopcart();
            $base_attributes['site_cart'] = $cart->getSiteCart();
        }

        $this->fill($base_attributes);
	}

    //------------------------------------------------------
	protected $attributes = [
        'app' => null,
        // 
        'web_user_id' => null,
        'web_user_data' => null,
        'web_user_isLoggedIn' => null,
        // 
        'posts_archive_name' => null,
        'posts_archive_index' => null,
        'posts_archive' => null,
        // 'content' => null,
        // 'content_rows' => null,
        // 
        // 'request' => null,
        // 
        'ui_mess' => null,
        'ui_mess_type' => null,
    ];
	
	protected $casts   = [];
}
