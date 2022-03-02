<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;
use Config\Services;

        

class ApiData extends Entity
{
    public function __construct()
	{
        
        parent::__construct();
       
        $base_attributes = [];
        $this->fill($base_attributes);
	}

    //------------------------------------------------------
	protected $attributes = [];
	
	protected $casts   = [];
}
