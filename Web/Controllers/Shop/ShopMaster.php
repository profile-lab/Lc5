<?php

namespace Lc5\Web\Controllers\Shop;

// use Lc5\Data\Models\PagesModel;
// use Lc5\Data\Models\ShopProductCatModel;
// use Lc5\Data\Models\ShopProductsModel;


// use CodeIgniter\I18n\Time;
// use CodeIgniter\Email\Email;
// use Config\Services;


// use stdClass;
// use CodeIgniter\API\ResponseTrait;



class ShopMaster extends \App\Controllers\BaseController
{
    protected $req;
    // 
    protected $shop_products_cat_model;
    protected $shop_products_model;
    //--------------------------------------------------------------------
    public function __construct()
    {
        $this->req = \Config\Services::request();
    }

    



    //-------------------------------------------------
    protected function getRegioneByCap($user_cap)
    {
        $caps_regioni = [
            'abruzzo' => ['min' => 64010, 'max' => 67100],
            'basilicata' => ['min' => 75010, 'max' => 85100],
            'calabria' => ['min' => 87010, 'max' => 89900],
            'campania' => ['min' => 80010, 'max' => 84135],
            'emilia_romagna' => ['min' => 29010, 'max' => 48100],
            'friuli_venezia_giulia' => ['min' => 33010, 'max' => 34170],
            'lazio' => ['min' => 00010, 'max' => 2011],
            'liguria' => ['min' => 12071, 'max' => 19137],
            'lombardia' => ['min' => 16192, 'max' => 46100],
            'marche' => ['min' => 60010, 'max' => 63900],
            'molise' => ['min' => 86010, 'max' => 86170],
            'piemonte' => ['min' => 10010, 'max' => 28925],
            'puglia' => ['min' => 70010, 'max' => 76125],
            // 'sardegna' => ['min' => 07010, 'max' => 09170 ],
            'sardegna' => ['min' => 07010, 'max' => 9170],
            'sicilia' => ['min' => 90010, 'max' => 98168],
            'toscana' => ['min' => 50010, 'max' => 59100],
            'trentino_alto_adige' => ['min' => 38010, 'max' => 39100],
            'umbria' => ['min' => 05010, 'max' => 06135],
            'valle_d_aosta' => ['min' => 11010, 'max' => 11100],
            'veneto' => ['min' => 30010, 'max' => 45100],
        ];
        foreach ($caps_regioni as $key => $c_caps) {
            if ($user_cap >= $c_caps['min'] && $user_cap <= $c_caps['max']) {
                return $key;
            }
        }
        return false;
    }
    //--------------------------------------------------------------------


     //-------------------------------------------------
    // protected function getFullCart()
    // {
    //     $piattiModel = new PiattiModel();
    //     $viniModel = new ViniModel();
    //     $piattiCatModel = new PiattiCatModel();
    //     $viniCatModel = new ViniCatModel();

    //     $cols = ['id', 'category', 'cover', 'guid', 'is_x_delivery', 'nome', 'prezzo', 'prezzo_delivery', 'prezzo_type'];
    //     $cols_wine = ['id', 'category', 'cover', 'guid', 'is_x_delivery', 'nome', 'prezzo', 'prezzo_delivery', 'prezzo_type', 'formato'];

    //     // 
    //     $referenze_totali = 0;
    //     $cart_total = 0;
    //     $site_cart_object = new \stdClass();
    //     $items = [];
    //     $has_food = false;

    //     if (!$cart = session()->get('site_cart')) {
    //         $cart = [];
    //     }
    //     // dd($cart);

    //     foreach ($cart as $key => $qnt) {

    //         $cart_item = new stdClass();
    //         $key_data = explode('_', $key);
    //         $item_type = $key_data[0];
    //         $item_id = $key_data[1];
    //         // 
    //         // 
    //         if ($item_type == 'p') {
    //             if ($item = $piattiModel->select($cols)->asObject()->find($item_id)) {
    //                 $has_food = TRUE;
    //                 $item->key = $key;
    //                 $item->type = $item_type;
    //                 //
    //                 $prod_categoria = $piattiCatModel->where('id', $item->category)
    //                     ->orderBy('id', 'ASC')
    //                     ->first();
    //                 if ($prod_categoria) {
    //                     $item->dett_url = (route_to('shop_prod', $prod_categoria->guid,  $item->guid));
    //                 } else {
    //                     $item->dett_url = null;
    //                 }
    //                 // 
    //                 $item->type_label = 'Dal menu';
    //                 if ($item->prezzo_delivery < 0.1) {
    //                     $item->prezzo_delivery = $item->prezzo - ($item->prezzo * 0.25);
    //                     $item->prezzo = null;
    //                 } else {
    //                     $item->prezzo = null;
    //                 }
    //                 $item->qnt = $qnt;
    //                 $item->total_row = $item->prezzo_delivery * $qnt;
    //                 // 
    //                 $referenze_totali += $qnt;
    //                 $cart_total += $item->total_row;
    //                 // 
    //                 $items[] = $item;
    //                 // 
    //             }
    //         } else {
    //             if ($item = $viniModel->select($cols_wine)->asObject()->find($item_id)) {
    //                 $item->key = $key;
    //                 $item->type = $item_type;
    //                 // 

    //                 $item->dett_url = (route_to('shop_cantina_dett', $item->guid, $item->id));

    //                 // 
    //                 $item->type_label = 'Dalla cantina';
    //                 if ($item->formato < 0.1) {
    //                     $item->formato = 0.75;
    //                 }
    //                 if ($item->prezzo_delivery < 0.1) {
    //                     $item->prezzo_delivery = $item->prezzo - ($item->prezzo * 0.25);
    //                     $item->prezzo = null;
    //                 } else {
    //                     $item->prezzo = null;
    //                 }
    //                 $item->qnt = $qnt;
    //                 $item->total_row = $item->prezzo_delivery * $qnt;
    //                 // 
    //                 $referenze_totali += $qnt;
    //                 $cart_total += $item->total_row;
    //                 // 
    //                 $items[] = $item;
    //                 // 

    //             }
    //         }
    //     }

    //     // dd($items);


    //     $site_cart_object->has_food = $has_food;
    //     $site_cart_object->items = $items;
    //     $site_cart_object->referenze_totali = $referenze_totali;
    //     $site_cart_object->referenze = count($cart);
    //     $site_cart_object->totale = $cart_total;
    //     // $site_cart_object->totale_imballaggio_spedizioni = ($cart_total > 0) ? $this->imballaggio_spedizioni[0] : 0;
    //     // $site_cart_object->totale_pagare = ($cart_total > 0) ? $cart_total + $this->imballaggio_spedizioni[0] : 0;
    //     return $site_cart_object;
    // }

    // //-------------------------------------------------
    // public function removeFromCart($cart_item_key)
    // {
    //     $referenze_totali = 0;
    //     $site_cart_object = new \stdClass();
    //     $prod_prefix = 'p_';

    //     if (!$cart = session()->get('site_cart')) {
    //         $cart = [];
    //     }
    //     if (isset($cart[$cart_item_key])) {
    //         unset($cart[$cart_item_key]);
    //     }
    //     foreach ($cart as $cart_item) {
    //         $referenze_totali += $cart_item;
    //     }

    //     session()->set(['site_cart' => $cart]);


    //     $site_cart_object->status = '201';
    //     $site_cart_object->mess = 'Prodotto rimosso dal carrello';
    //     $site_cart_object->cart = $cart;
    //     $site_cart_object->referenze_totali = $referenze_totali;
    //     $site_cart_object->referenze = count($cart);

    //     if ($returnTo = $this->req->getGet('returnTo')) {
    //         return $this->response->redirect($returnTo);
    //     }


    //     return $this->setResponseFormat('json')->respond($site_cart_object);
    // }
    // //-------------------------------------------------
    // public function removeQntFromCart($cart_item_key)
    // {
    //     $referenze_totali = 0;
    //     $site_cart_object = new \stdClass();
    //     $prod_prefix = 'p_';

    //     if (!$cart = session()->get('site_cart')) {
    //         $cart = [];
    //     }
    //     $new_cart = [];

    //     foreach ($cart as $key => $cart_item) {
    //         if ($key == $cart_item_key) {
    //             if ($cart_item > 1) {
    //                 $cart_item--;
    //                 $referenze_totali += $cart_item;
    //                 $new_cart[$key] = $cart_item;
    //             }
    //         } else {
    //             $referenze_totali += $cart_item;
    //             $new_cart[$key] = $cart_item;
    //         }
    //     }
    //     $cart = $new_cart;

    //     session()->set(['site_cart' => $cart]);


    //     $site_cart_object->status = '201';
    //     $site_cart_object->mess = 'Prodotto rimosso dal carrello';
    //     $site_cart_object->cart = $cart;
    //     $site_cart_object->referenze_totali = $referenze_totali;
    //     $site_cart_object->referenze = count($cart);

    //     if ($returnTo = $this->req->getGet('returnTo')) {
    //         return $this->response->redirect($returnTo);
    //     }


    //     return $this->setResponseFormat('json')->respond($site_cart_object);
    // }
}
