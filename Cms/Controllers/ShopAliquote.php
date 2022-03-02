<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\ShopAliquoteModel as CurrentModel;
use Lc5\Data\Entities\ShopAliquota  as CurrentEntity;



class ShopAliquote extends MasterLc
{
    // private $post_attributes;
    protected $current_shop_setting;


    public function __construct()
    {
        parent::__construct();
        // 
        $this->module_name = 'Aliquote Iva';
        $this->route_prefix = 'lc_shop_aliquote';
        // 
        $this->lc_ui_date->__set('request', $this->req);
        $this->lc_ui_date->__set('route_prefix', $this->route_prefix);
        $this->lc_ui_date->__set('module_name', $this->module_name);
        $this->lc_ui_date->__set('currernt_module', 'shopproduct');
        $this->lc_ui_date->__set('currernt_module_action', 'shopsettings');
        $this->lc_ui_date->__set('currernt_module_tab', 'shopaliquote');
        $this->lc_ui_date->__set('shop_tools_tabs', $this->getShopToolsTabs());
        // 
        $this->current_shop_setting  = $this->getShopSettings();
        $this->lc_ui_date->__set('current_shop_setting', $this->current_shop_setting);

    }





    //--------------------------------------------------------------------
    public function index()
    {
        // 
        $shop_products_tags_model = new CurrentModel();
        // 
        $list = $shop_products_tags_model->findAll();
        $this->lc_ui_date->list = $list;
        // 
        return view('Lc5\Cms\Views\shop/aliquote/index', $this->lc_ui_date->toArray());
    }





    //--------------------------------------------------------------------
    public function newpost()
    {
        $this->lc_ui_date->__set('back_to_list_btn_url', route_to($this->route_prefix));
        // 
        $shop_products_tags_model = new CurrentModel();
        $curr_entity = new CurrentEntity();
        // 
        if ($this->req->getMethod() == 'post') {
            $validate_rules = [
                'nome' => ['label' => 'Nome', 'rules' => 'required'],
                'val' => ['label' => 'Valore', 'rules' => 'required'],
            ];
            $curr_entity->fill($this->req->getPost());
            if ($this->validate($validate_rules)) {
                $shop_products_tags_model->save($curr_entity);
                // 
                $new_id = $shop_products_tags_model->getInsertID();
                return redirect()->route($this->route_prefix . '_edit', [$new_id]);
            } else {
                $this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
                $this->lc_ui_date->ui_mess_type = 'alert alert-danger';
            }
        }
        // 
        $this->lc_ui_date->entity = $curr_entity;
        return view('Lc5\Cms\Views\shop/aliquote/scheda', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function edit($id)
    {
        $this->lc_ui_date->__set('back_to_list_btn_url', route_to($this->route_prefix));
        // 
        $shop_products_tags_model = new CurrentModel();
        if (!$curr_entity = $shop_products_tags_model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // 
        if ($this->req->getMethod() == 'post') {
            $validate_rules = [
                'nome' => ['label' => 'Nome', 'rules' => 'required'],
                'val' => ['label' => 'Valore', 'rules' => 'required'],
            ];
            $curr_entity->fill($this->req->getPost());
            if ($this->validate($validate_rules)) {
                if ($curr_entity->hasChanged('nome') || $curr_entity->hasChanged('val')) {
                    $shop_products_tags_model->save($curr_entity);
                }
                // 
                return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
            } else {
                $this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
                $this->lc_ui_date->ui_mess_type = 'alert alert-danger';
            }
        }
        // 
        $this->lc_ui_date->entity = $curr_entity;
        return view('Lc5\Cms\Views\shop/aliquote/scheda', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function delete($id)
    {
        $shop_products_tags_model = new CurrentModel();
        if (!$curr_entity = $shop_products_tags_model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $shop_products_tags_model->delete($curr_entity->id);
        return redirect()->route($this->route_prefix);
    }
}
