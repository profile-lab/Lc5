<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\AppSettingsModel;

use Lc5\Data\Entities\AppSetting as AppSettingEntity;


class AppSettings extends MasterLc
{
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->module_name = 'App Settings';
        $this->route_prefix = 'lc_app_settings';
        // 
        $this->lc_ui_date->__set('request', $this->req);
        $this->lc_ui_date->__set('route_prefix', $this->route_prefix);
        $this->lc_ui_date->__set('module_name', $this->module_name);
        // 

    }

    //--------------------------------------------------------------------
    public function edit()
    {
        // 
        $app_settings_model = new AppSettingsModel();
        if (!$curr_entity = $app_settings_model->where('id_app', $this->getCurrApp())->where('lang', $this->getCurrLang())->first()) {
            $this->createBeseAppSettings();
            if (!$curr_entity = $app_settings_model->where('id_app', $this->getCurrApp())->where('lang', $this->getCurrLang())->first()) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
        // 

        // 
        if ($this->req->getPost()) {
            $validate_rules = [
                'save' => ['label' => 'Save', 'rules' => 'required'],
                // 'nome' => ['label' => 'Nome', 'rules' => 'required'],
            ];
            $is_falied = TRUE;
            $curr_entity->fill($this->req->getPost());
            // 
            if ($this->validate($validate_rules)) {
                if ($curr_entity->hasChanged()) { 
                    $app_settings_model->save( $curr_entity );
                }
                // 
                return redirect()->route($this->route_prefix, [$curr_entity->id]);
            } else {
                $this->lc_ui_date->ui_mess =  $this->lc_parseValidator($this->validator->getErrors());
                $this->lc_ui_date->ui_mess_type = 'alert alert-danger';
            }
        }
        // 
        $this->lc_ui_date->entity = $curr_entity;
        return view('Lc5\Cms\Views\app-settings/scheda', $this->lc_ui_date->toArray());
    }


}
