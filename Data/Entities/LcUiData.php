<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;
use Config\Services;

        

class LcUiData extends Entity
{
    public $module_folder_index = 2;
    public function __construct()
	{
        
        parent::__construct();
        $uri = service('uri');

        // $admins = Services::admins();
        $base_attributes = [
            'admin_id' => session()->get('admin_id'),
            'admin_data' => session()->get('admin_data'),
            'isAdminLoggedIn' => session()->get('isAdminLoggedIn'),
            // 
            // 'currernt_module' => $uri->setSilent()->getSegment($this->module_folder_index),


            // 'currernt_module_action' => ($uri->setSilent()->getSegment($this->module_folder_index+1) != 'edit') ? $uri->setSilent()->getSegment($this->module_folder_index+1) : '',
        ];
        // $attributes = [
        //     'isAdminLoggedIn' => true
        // ];
        $this->fill($base_attributes);
	}

    //------------------------------------------------------
	protected $attributes = [
        'admin_id' => null,
        'admin_data' => null,
        'isAdminLoggedIn' => null,
        'currernt_module' => null,
        'currernt_module_action' => null,
        // 
        'list' => null,
        'entity' => null,
        'entity_rows' => null,
        // 
        'request' => null,
        'route_prefix' => '',
        'module_name' => '',
        // 
        'ui_mess' => null,
        'ui_mess_type' => null,
    ];
	
	protected $casts   = [];
}
