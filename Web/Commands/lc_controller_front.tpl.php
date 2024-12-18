<@php

namespace App\Controllers;

use App\Models\{model_class};
use Lc5\Web\Controllers\MasterWeb;

class {class} extends MasterWeb
{

    private $module_model;

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
		// 
		$this->web_ui_date->__set('request', $this->req);
        $this->web_ui_date->__set('route_prefix', '{nome_modulo}');
        // 
        $this->module_model = new {model_class}();
		// 
    }

    //--------------------------------------------------------------------
    public function index()
    {
        //
    }

    //--------------------------------------------------------------------

}
