<?php

namespace Lc5\Web\Controllers\Shop;

use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\ShopProductCatModel;
use Lc5\Data\Models\ShopProductsModel;
use stdClass;

class Products extends ShopMaster
{
    // private $shop_products_cat_model;
    // private $shop_products_model;
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        // $this->shop_products_cat_model = new ShopProductCatModel();
        // $this->shop_products_model = new ShopProductsModel();
        $categories = $this->shop_products_cat_model->asObject()->findAll();
        foreach ($categories as $category) {
            $category->permalink = route_to(__locale_uri__ . 'web_shop_category_archive', $category->guid);
        }
        $this->web_ui_date->__set('categories', $categories);
        // 
        $this->web_ui_date->__set('request', $this->req);
        // 

       
    }

    // //--------------------------------------------------------------------
    // private function checkCartAction($category_guid = null)
    // {
    //     if ($this->req->getMethod() == 'post') {
    //         d('web_cart' );
    //         return true;
    //     }
    // }

    //--------------------------------------------------------------------
    public function index($category_guid = null)
    {
        if($this->checkCartAction()){
            return redirect()->to(site_url(uri_string()));
        }
        $pages_entity_rows = null;
        $products_archive_qb = $this->shop_products_model->asObject();
        $products_archive_qb->where('parent', 0);
        if ($category_guid != null) {
            if ($curr_entity =  $this->shop_products_cat_model->where('guid', $category_guid)->asObject()->first()) {
                $products_archive_qb->where('category', $curr_entity->id);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            $pages_model = new PagesModel();
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
                $product->permalink = route_to(__locale_uri__ . 'web_shop_single', $product->guid);
                // 
                $this->extendProduct($product, 'min');
                // 
            }
            $curr_entity->products_archive  = $products_archive;
        }
        $this->web_ui_date->fill((array)$curr_entity);
        $this->web_ui_date->entity_rows = $pages_entity_rows;
        return view($this->base_view_namespace . 'shop/archive', $this->web_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function post($guid)
    {
        
        $qb = $this->shop_products_model->asObject()->orderBy('id', 'DESC');
        if ($guid) {
            $qb->where('guid', $guid);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if (!$curr_entity = $qb->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // 
        $this->extendProduct($curr_entity);
        // 
        $this->web_ui_date->fill((array)$curr_entity);
        // 
        return view($this->base_view_namespace . 'shop/detail', $this->web_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    // ---- TOOLS ----
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------

    private function extendProduct(&$product, $select =null){
        if($product->category > 0){
           $category_obj_qb= $this->shop_products_cat_model->asObject()->where('id', $product->category);
           if($select == 'min'){
                $category_obj_qb->select(['id','nome','titolo','guid']);
            }
            if ($product->category_obj = $category_obj_qb->first()) {
                $product->category_obj->permalink = route_to(__locale_uri__ . 'web_shop_category_archive', $product->category_obj->guid);
            }
        }else{
            $product->category_obj = null;
        }
        // // MODELLI 
        $modelli_qb = $this->shop_products_model->asObject()->where('parent', $product->id);
        if($select == 'min'){
            $modelli_qb->select(['id','nome','titolo','guid','price','ali']);
        }
        $product->modelli = $modelli_qb->findAll();
        // // FINE MODELLI 
        // 
    }
}
