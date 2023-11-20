<@php

namespace App\Controllers\LcCustom;

use App\Entities\{entity_class};
use App\Models\{model_class};
use Lc5\Cms\Controllers\MasterLc;


class {class} extends MasterLc
{

    private $module_model;

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->module_name = '{class}';
        $this->route_prefix = 'lc_{nome_modulo}';
        // 
        $this->lc_ui_date->__set('request', $this->req);
        $this->lc_ui_date->__set('route_prefix', $this->route_prefix);
        $this->lc_ui_date->__set('module_name', $this->module_name);
        // 
        $this->module_model = new ProductsModel();
        // 
    }

    //--------------------------------------------------------------------
    public function index()
    {
        //
        $list = $this->module_model->findAll();
        $this->lc_ui_date->list = $list;
        // 
        return view('Views/lc-custom/{nome_modulo}/index', $this->lc_ui_date->toArray());
    }
    
    //--------------------------------------------------------------------
    public function newpost()
    {
        //
        $curr_entity = new {entity_class}();
        //
        if ($this->req->getMethod() == 'post') {
            $validate_rules = [
                'nome' => ['label' => 'Nome', 'rules' => 'required'],
            ];
            $curr_entity->fill($this->req->getPost());
            if ($this->validate($validate_rules)) {
                $this->module_model->save($curr_entity);
                // 
                $new_id = $this->module_model->getInsertID();
                return redirect()->route($this->route_prefix . '_edit', [$new_id]);
            } else {
                $this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
                $this->lc_ui_date->ui_mess_type = 'alert alert-danger';
            }
        }
        // 
        $this->lc_ui_date->entity = $curr_entity;
        return view('Views/lc-custom/{nome_modulo}/scheda', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function edit($id)
    {
        //
        if (!$curr_entity = $this->module_model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // 
        if ($this->req->getMethod() == 'post') {
            $validate_rules = [
                'nome' => ['label' => 'Nome', 'rules' => 'required'],
            ];
            $curr_entity->fill($this->req->getPost());
            if ($this->validate($validate_rules)) {
                $this->module_model->save($curr_entity);
                // 
                return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
            } else {
                $this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
                $this->lc_ui_date->ui_mess_type = 'alert alert-danger';
            }
        }
        // 
        $this->lc_ui_date->entity = $curr_entity;
        return view('Views/lc-custom/{nome_modulo}/scheda', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function delete($id)
    {
        if (!$curr_entity = $this->module_model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->module_model->delete($curr_entity->id);
        return redirect()->route($this->route_prefix);
    }

}
