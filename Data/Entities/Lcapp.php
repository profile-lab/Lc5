<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Lcapp extends Entity
{
	protected $attributes = [
		'id' => null,
		'nome' => null,
		'apikey' => null,

		'domain' => null, 
		// 'email' => null, 
		// 'phone' => null, 
		// 'address' => null, 
		// 'piva' => null, 
		// 'copy' => null, 
		// 'app_description' => null, 
		// 'facebook' => null, 
		// 'instagram' => null, 
		// 'twitter' => null, 
		// 'maps' => null, 
		// 'shop' => null, 
		// 'seo_title' => null, 
		// 'app_claim' => null,

		'labels_json_object' => null,

    ];
}
