<@php

namespace App\Controllers\LcCustom;

use App\Entities\{entity_class};
use App\Models\{model_class};
use Lc5\Cms\Controllers\MasterLc;


class {class} extends MasterLc
{
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
    }

    //--------------------------------------------------------------------
    public function index()
    {
        //
    }

    //--------------------------------------------------------------------

}
