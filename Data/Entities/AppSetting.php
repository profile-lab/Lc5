<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class AppSetting extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => null,
		'lang' => null,
		'email' => null, 
		'phone' => null, 
		'address' => null, 
		'piva' => null, 
		'copy' => null, 
		'app_description' => null, 
		'facebook' => null, 
		'instagram' => null, 
		'twitter' => null, 
		'maps' => null, 
		'youtube' => null, 
		'linkedin' => null, 
		'shop' => null, 
		'seo_title' => null, 
		'app_claim' => null,
        'entity_free_values' => null, 
    ];
}
