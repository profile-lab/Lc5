<?php

namespace Lc5\Web\Controllers\Shop;

use Lc5\Data\Models\ShopProductsModel;
use Lc5\Data\Models\ShopSettingsModel;

class Cart extends ShopMaster
{
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
    //--------------------------------------------------------------------
    public function checkCartAction() //($category_guid = null)
    {

        if ($this->req->getMethod() == 'post') {
            if ($this->req->getPost('cart_action') == 'ADD') {
                if ($this->addToCart($this->req->getPost('prod_id'), 'p_')) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    //-------------------------------------------------
    public function addToCart($product_id,  $prod_prefix = 'p_')
    {

        // dd($this->req->getPost());

        $referenze_totali = 0;
        $site_cart_object = new \stdClass();


        if (!$cart = session()->get('site_cart')) {
            $cart = [];
        }
        $cart_index = $prod_prefix . $product_id . '_' . $this->req->getPost('prod_model_id');
        if (isset($cart[$cart_index])) {
            $cart[$cart_index] += ($this->req->getPost('prod_qty')) ? $this->req->getPost('prod_qty') : 1;
        } else {
            $cart[$cart_index] = ($this->req->getPost('prod_qty')) ? $this->req->getPost('prod_qty') : 1;
        }
        foreach ($cart as $cart_item) {
            $referenze_totali += $cart_item;
        }

        session()->set(['site_cart' => $cart]);


        $site_cart_object->status = '201';
        $site_cart_object->mess = 'Prodotto aggiunto al carrello<br /><a class="go_to_cart_in_mess" href="' . site_url(route_to('site_cart')) . '" title="Vai al carrello"><span class="menu-item-label">Vai al carrello</span><i class="fas fa-shopping-cart nav-link-icon"></i></a>';
        $site_cart_object->cart = $cart;
        $site_cart_object->referenze_totali = $referenze_totali;
        $site_cart_object->referenze = count($cart);

        //  dd($site_cart_object);


        return $site_cart_object;
    }

    //-------------------------------------------------
    public function svuotaCarrello()
    {
        session()->set(['site_cart' => null]);
    }
    //-------------------------------------------------
    public function removeRow($row_key)
    {
        if (!$cart = session()->get('site_cart')) {
            $cart = [];
        }
        if(isset($cart[$row_key])){
            unset($cart[$row_key]);
        }
        session()->set(['site_cart' => $cart]);
        return $cart;
    }
    //-------------------------------------------------
    public function incrementRow($row_key)
    {
        if (!$cart = session()->get('site_cart')) {
            $cart = [];
        }
        if(isset($cart[$row_key])){
           $cart[$row_key]+= 1;
        }
        session()->set(['site_cart' => $cart]);
        return $cart;
    }
    //-------------------------------------------------
    public function decrementRow($row_key)
    {
        if (!$cart = session()->get('site_cart')) {
            $cart = [];
        }
        if(isset($cart[$row_key])){
            $cart[$row_key]-= 1;
            if($cart[$row_key] < 1){
                unset($cart[$row_key]);
            }
         }
        session()->set(['site_cart' => $cart]);
        return $cart;
    }

    //-------------------------------------------------
    public function getSiteCart()
    {
        $processed_cart = [];
        if ($cart = session()->get('site_cart')) {
            $shop_settings = $this->getShopSettings();
            // 
            $shop_products_model = new ShopProductsModel();
            $shop_products_model->shop_settings = $shop_settings;
            if (is_iterable($cart)) {
                foreach ($cart as $key => $qnt) {
                    $key_parameters = explode('_', $key);
                    if (isset($key_parameters[1])) {
                        if ($prod = $shop_products_model->select(['id', 'nome', 'titolo', 'modello', 'giacenza', 'guid', 'price', 'promo_price', 'ali'])->asObject()->find($key_parameters[1])) {
                            $permalink = route_to(__locale_uri__.'web_shop_detail',$prod->guid);
                            if (isset($key_parameters[2]) && $key_parameters[2] != $key_parameters[1] && $modello = $shop_products_model->select(['id', 'nome', 'titolo', 'modello', 'giacenza', 'guid', 'price', 'promo_price', 'ali'])->asObject()->find($key_parameters[2])) {
                                if ($modello->price < 0.01) {
                                    $modello->prezzo = $prod->prezzo;
                                }
                                $permalink = route_to(__locale_uri__.'web_shop_detail_model',$prod->guid, $modello->id);
                            
                            } else {
                                $modello = $prod;
                            }

                            $processed_cart[$key] = (object) [
                                'row_key' => $key,
                                'permalink' => $permalink,
                                'full_nome_prodotto' => $modello->full_nome_prodotto,
                                'nome' => $prod->nome,
                                'modello' => $modello->modello,
                                'qnt' => $qnt,
                                'prezzo_uni' => number_format(($modello->prezzo), 2, ',', '.'),
                                'prezzo' => number_format(($modello->prezzo*$qnt), 2, ',', '.')
                            ];
                        }
                    }
                }
            }
        }
        // d($processed_cart);
        return $processed_cart;
    }





    // //-------------------------------------------------
    // public function addQntFromCart($product_id, $model_id = 0, $quantity = 1)
    // {
    //     $referenze_totali = 0;
    //     $site_cart_object = new \stdClass();
    //     $prod_prefix = 'p_';

    //     if (!$cart = session()->get('site_cart')) {
    //         $cart = [];
    //     }
    //     $new_cart = [];

    //     foreach ($cart as $key => $cart_item) {
    //         if ($key == $prod_prefix . $product_id . '_' . $model_id) {
    //             $cart_item += $quantity;
    //         }
    //         $referenze_totali += $cart_item;
    //         $new_cart[$key] = $cart_item;
    //     }
    //     $cart = $new_cart;

    //     session()->set(['site_cart' => $cart]);


    //     $site_cart_object->status = '201';
    //     $site_cart_object->mess = 'Prodotto aggiunto al carrello';
    //     $site_cart_object->cart = $cart;
    //     $site_cart_object->referenze_totali = $referenze_totali;
    //     $site_cart_object->referenze = count($cart);

    //     if ($returnTo = $this->req->getGet('returnTo')) {
    //         return $this->response->redirect($returnTo);
    //     }


    //     return $this->setResponseFormat('json')->respond($site_cart_object);
    // }









}
