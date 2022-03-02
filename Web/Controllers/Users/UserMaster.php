<?php

namespace Lc5\Web\Controllers\Users;

class UserMaster extends \App\Controllers\BaseController
{
    protected $req;
    
    
    //--------------------------------------------------------------------
    public function __construct()
    {
        $this->req = \Config\Services::request();
    }

    
}
