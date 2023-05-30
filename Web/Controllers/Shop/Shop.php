<?php

namespace Lc5\Web\Controllers\Shop;

use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\ShopProductsModel;
use Lc5\Data\Models\ShopSettingsModel;

// 
use Lc5\Data\Models\ShopProductsCategoriesModel;
use Lc5\Data\Models\ShopProductsTagsModel;
use Lc5\Data\Models\ShopProductsColorsModel;
use Lc5\Data\Models\ShopProductsSizesModel;

use Config\Services;

use stdClass;

class Shop extends \Lc5\Web\Controllers\MasterWeb
{
    private $shop_products_cat_model;
    private $shop_products_model;
    private $shop_products_tags_model;
    private $shop_products_colors_model;
    private $shop_products_sizes_model;
    // 
    private $cart;
    private $categories;
    private $tags;
    private $colors;
    private $sizes;

    private $shop_settings;

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->shop_settings = $this->getShopSettings();
        // 
        $this->shop_products_cat_model = new ShopProductsCategoriesModel();
        $this->shop_products_cat_model->setForFrontemd();
        $this->shop_products_model = new ShopProductsModel();
        $this->shop_products_model->setForFrontemd();
        $this->shop_products_model->shop_settings = $this->shop_settings;

        $this->shop_products_tags_model = new ShopProductsTagsModel();
        $this->shop_products_tags_model->setForFrontemd();
        $this->shop_products_colors_model = new ShopProductsColorsModel();
        $this->shop_products_colors_model->setForFrontemd();
        $this->shop_products_sizes_model = new ShopProductsSizesModel();
        $this->shop_products_sizes_model->setForFrontemd();
        // 
        $this->cart = Services::shopcart(); // new Cart();
        // 

        // 
        $this->categories = $this->shop_products_cat_model->asObject()->findAll();
        foreach ($this->categories as $category) {
            $category->permalink = route_to(__locale_uri__ . 'web_shop_category', $category->guid);
        }
        $this->web_ui_date->__set('categories', $this->categories);
        // 
        $this->tags = $this->shop_products_tags_model->asObject()->findAll();
        // foreach ($this->tags as $tag) {
        //     $tag->permalink = route_to(__locale_uri__ . 'web_shop_category', $category->guid);
        // }
        $this->web_ui_date->__set('tags', $this->tags);
        // 
        $this->colors = $this->shop_products_colors_model->asObject()->findAll();
        // foreach ($this->colors as $color) {
        //     $color->permalink = route_to(__locale_uri__ . 'web_shop_category', $color->guid);
        // }
        $this->web_ui_date->__set('colors', $this->colors);
        // 
        $this->sizes = $this->shop_products_sizes_model->asObject()->findAll();
        // foreach ($this->sizes as $size) {
        //     $tag->permalink = route_to(__locale_uri__ . 'web_shop_category', $size->guid);
        // }
        $this->web_ui_date->__set('sizes', $this->sizes);
        // 

        // 
        $this->web_ui_date->__set('request', $this->req);
        // 


    }


    //--------------------------------------------------------------------
    public function index($category_guid = null)
    {

        if ($this->cart->checkCartAction()) {
            return redirect()->to(site_url(uri_string()));
        }
        $pages_entity_rows = null;
        $products_archive_qb = $this->shop_products_model->asObject();
        $products_archive_qb->where('parent', 0);
        // $products_archive_qb->where('(parent IS NULL OR parent <  1 )');
        if ($category_guid != null) {
            if ($curr_entity =  $this->shop_products_cat_model->where('guid', $category_guid)->asObject()->first()) {
                $products_archive_qb->where('category', $curr_entity->id);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            $pages_model = new PagesModel();
            $pages_model->setForFrontemd();
            if ($curr_entity = $pages_model->asObject()->orderBy('id', 'DESC')->where('guid', 'shop')->first()) {
                $pages_entity_rows = $this->getEntityRows($curr_entity->id, 'pages');
            } else {
                $curr_entity = new stdClass();
                $curr_entity->titolo = 'Shop';
                $curr_entity->guid = 'shop';
                $curr_entity->testo = '';
                $curr_entity->seo_title = 'Il nostro e-commerce';
                $curr_entity->seo_description = 'Naviga il nostro e-commerce e acquista i nostri prodotti';
            }
        }
        if ($products_archive = $this->shop_products_model->asObject()->findAll()) {
            foreach ($products_archive as $product) {
                $product->abstract = word_limiter(strip_tags($product->testo), 20);
                // $post->abstract = character_limiter(strip_tags( $post->testo ), 100);
                $product->permalink = route_to(__locale_uri__ . 'web_shop_detail', $product->guid);
                // 
                $this->shop_products_model->extendProduct($product, 'min');
                // $this->extendProduct($product, 'min');
                // 
            }
            $curr_entity->products_archive  = $products_archive;
        }
        // dd($products_archive);
        $this->web_ui_date->fill((array)$curr_entity);
        $this->web_ui_date->entity_rows = $pages_entity_rows;
        return view($this->base_view_namespace . 'shop/archive', $this->web_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function detail($product_guid, $model_id = null)
    {
        if ($this->cart->checkCartAction()) {
            return redirect()->to(site_url(uri_string()));
        }
        $pages_entity_rows = null;
        if (!$model_id) {

            $products_archive_qb = $this->shop_products_model->asObject();
            $products_archive_qb->where('parent', 0);
            if (!$curr_entity = $this->shop_products_model->where('guid', $product_guid)->asObject()->first()) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            $this->shop_products_model->extendProduct($curr_entity, 'min');
        } else {
            // $products_archive_qb = $this->shop_products_model->asObject();
            // $products_archive_qb->where('parent', 0);
            // if (!$curr_parent_entity = $this->shop_products_model->where('guid', $product_guid)->asObject()->first()) {
            //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            // }
            $products_archive_qb = $this->shop_products_model->asObject();
            // $products_archive_qb->where('parent', $curr_parent_entity->id);
            if (!$curr_entity = $this->shop_products_model->where('id', $model_id)->asObject()->first()) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            $this->shop_products_model->extendModelByParent($curr_entity, 'min');
        }


        // $this->extendProduct($curr_entity, 'min');
        // dd($curr_entity);
        $this->web_ui_date->fill((array)$curr_entity);
        $this->web_ui_date->entity_rows = $pages_entity_rows;
        return view($this->base_view_namespace . 'shop/detail', $this->web_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function emptyCart()
    {
        $this->cart->svuotaCarrello();
        return redirect()->to(previous_url());
    }
    //--------------------------------------------------------------------
    public function cartIncrementQnt($row_key)
    {
        $this->cart->incrementRow($row_key);
        return redirect()->to(previous_url());
    }
    //--------------------------------------------------------------------
    public function cartDecrementQnt($row_key)
    {
        $this->cart->decrementRow($row_key);
        return redirect()->to(previous_url());
    }
    //--------------------------------------------------------------------
    public function cartRemoveRow($row_key)
    {
        $this->cart->removeRow($row_key);
        return redirect()->to(previous_url());
    }


    //--------------------------------------------------------------------
    public function carrello()
    {

        if ($this->cart->checkCartAction()) {
            return redirect()->to(site_url(uri_string()));
        }
        $pages_entity_rows = null;
        $products_archive_qb = $this->shop_products_model->asObject();
        $products_archive_qb->where('parent', 0);
        // $products_archive_qb->where('(parent IS NULL OR parent <  1 )');

        $pages_model = new PagesModel();
        $pages_model->setForFrontemd();
        if ($curr_entity = $pages_model->asObject()->orderBy('id', 'DESC')->where('guid', 'cart')->first()) {
            $pages_entity_rows = $this->getEntityRows($curr_entity->id, 'pages');
        } else {
            $curr_entity = new stdClass();
            $curr_entity->titolo = 'Carrello';
            $curr_entity->guid = 'carrello';
            $curr_entity->testo = '';
            $curr_entity->seo_title = 'Il tuo carrello';
            $curr_entity->seo_description = 'Il tuo carrello';
        }
        
        $this->web_ui_date->fill((array)$curr_entity);
        $this->web_ui_date->entity_rows = $pages_entity_rows;
        return view($this->base_view_namespace . 'shop/site-cart', $this->web_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    // ---- TOOLS ----
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------


    // //--------------------------------------------------------------------
    // protected function getShopSettings()
    // {
    //     // 
    //     $shop_settings_model = new ShopSettingsModel();
    //     $shop_settings_model->setForFrontemd();
    //     if (!$shop_settings_entity = $shop_settings_model->asObject()->where('id_app', __web_app_id__ )->first()) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }
    //     // 
    //     return $shop_settings_entity;
    // }


    // private function extendProduct(&$product, $select = null)
    // {
    //     if ($product->category > 0) {
    //         $category_obj_qb = $this->shop_products_cat_model->asObject()->where('id', $product->category);
    //         if ($select == 'min') {
    //             $category_obj_qb->select(['id', 'nome', 'titolo', 'guid']);
    //         }
    //         if ($product->category_obj = $category_obj_qb->first()) {
    //             $product->category_obj->permalink = route_to(__locale_uri__ . 'web_shop_category', $product->category_obj->guid);
    //         }
    //     } else {
    //         $product->category_obj = null;
    //     }
    //     // // MODELLI 
    //     $modelli_qb = $this->shop_products_model->asObject()->where('parent', $product->id);
    //     if ($select == 'min') {
    //         $modelli_qb->select(['id', 'nome', 'titolo','modello', 'giacenza', 'guid', 'price', 'ali']);
    //     }
    //     $product->has_modelli = FALSE;
    //     // 
    //     $models_list = [];
    //     $modello_base = (object) [
    //         'ali' => $product->ali,
    //         'alt_img_obj' => $product->alt_img_obj,
    //         'alt_img_path' => $product->alt_img_path,
    //         'entity_free_values_object' => $product->entity_free_values_object,
    //         'gallery_obj' => $product->gallery_obj,
    //         'guid' => $product->guid,
    //         'id' => $product->id,
    //         'imponibile' => $product->imponibile,
    //         'iva' => $product->iva,
    //         'main_img_obj' => $product->main_img_obj,
    //         'main_img_path' => $product->main_img_path,
    //         'nome' => $product->nome,
    //         'prezzo' => $product->prezzo,
    //         'prezzo_pieno' => $product->prezzo_pieno,
    //         'price' => $product->price,
    //         'tags' => $product->tags,
    //         'titolo' => $product->titolo,
    //         'modello' => $product->modello,
    //         'giacenza' => $product->giacenza,
    //     ];
    //     $models_list[] = $modello_base;
    //     // 
    //     if ($modelli = $modelli_qb->findAll()) {

    //         foreach ($modelli as $modello) {
    //             $models_list[] = $modello;
    //         }
    //         $product->has_modelli = TRUE;
    //     }
    //     $product->modelli = $models_list;
    //     // // FINE MODELLI 
    //     // 
    // }
}
