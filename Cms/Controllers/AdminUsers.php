<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\AdminsModel;

use Lc5\Data\Entities\Admin;
// use Lc5\Data\Entities\LoginDati;
// use stdClass;

class AdminUsers extends MasterLc
{
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->module_name = 'Admin Users';
        $this->route_prefix = 'lc_admin_users';
        // 
        $this->lc_ui_date->__set('request', $this->req);
        $this->lc_ui_date->__set('route_prefix', $this->route_prefix);
        $this->lc_ui_date->__set('module_name', $this->module_name);
        // 

    }

    //--------------------------------------------------------------------
    public function index()
    {
        // 
        $admins_model = new AdminsModel();
        // 
        $list = $admins_model->findAll();
        $this->lc_ui_date->list = $list;
        // 
        return view('Lc5\Cms\Views\admin-users/index', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function newpost()
    {
        // 
        $admins_model = new AdminsModel();
        $curr_entity = new Admin();
        // 
        if ($this->req->getPost()) {
            $validate_rules = [
                'name' => ['label' => 'Nome', 'rules' => 'required'],
                'email' => ['label' => 'Email', 'rules' => 'required|valid_email|is_unique[admins.email]'],
                'new_password' => ['label' => 'Password', 'rules' => 'required|min_length[8]'],
                'confirm_new_password' => ['label' => 'Conferma Password', 'rules' => 'required|matches[new_password]'],
            ];
            $curr_entity->fill($this->req->getPost());
            if ($this->validate($validate_rules)) {
                $curr_entity->password = $curr_entity->new_password;
                $curr_entity->status =1;

                if ($curr_lc_app = session()->get('curr_lc_app')) {
                    $curr_entity->id_app = $curr_lc_app;
                }

                if ($curr_entity->hasChanged()) { 
                    $admins_model->save( $curr_entity );
                }
                // 
                $new_id = $admins_model->getInsertID();

                // 
                return redirect()->route($this->route_prefix . '_edit', [$new_id]);
            } else {
                $this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
                $this->lc_ui_date->ui_mess_type = 'alert alert-danger';
            }
        }
        // 
        $this->lc_ui_date->entity = $curr_entity;
        return view('Lc5\Cms\Views\admin-users/scheda', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function delete($id)
    {
        $admins_model = new AdminsModel();
		if (!$curr_entity = $admins_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$admins_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix);
    }

    //--------------------------------------------------------------------
    public function edit($id)
    {
        // 
        $admins_model = new AdminsModel();
        if (!$curr_entity = $admins_model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // 

        // 
        if ($this->req->getPost()) {
            $validate_rules = [
                'name' => ['label' => 'Nome', 'rules' => 'required'],
                'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            ];
            
            $is_falied = TRUE;
            $curr_entity->fill($this->req->getPost());
            if($this->req->getPost('new_password')){

                $validate_rules['new_password'] = ['label' => 'Password', 'rules' => 'required|min_length[8]'];
                $validate_rules['confirm_new_password'] = ['label' => 'Conferma Password', 'rules' => 'required|matches[new_password]'];
                $curr_entity->password = $curr_entity->new_password;
            }
            // dd($curr_entity);
            // 
            if ($this->validate($validate_rules)) {
                if ($curr_entity->hasChanged()) { 
                    $admins_model->save( $curr_entity );
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
        return view('Lc5\Cms\Views\admin-users/scheda', $this->lc_ui_date->toArray());
    }
    //--------------------------------------------------------------------
    
}
