<@php

namespace App\Controllers;

use App\Entities\{entity_class};
use App\Models\{model_class};
use Lc5\Web\Controllers\MasterWeb;

class {class} extends MasterWeb
{
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
		// 
		$this->web_ui_date->__set('request', $this->req);
        $this->web_ui_date->__set('route_prefix', '{nome_modulo}');
		// 
    }

    //--------------------------------------------------------------------
    public function index()
    {
        //
    }

    //--------------------------------------------------------------------

}
