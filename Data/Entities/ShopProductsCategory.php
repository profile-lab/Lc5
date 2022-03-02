<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class ShopProductsCategory extends Entity
{
	protected $attributes = [
		'id_app' => null,
        'lang' => null,
        'parent' => null,
        'ordine' => null,
        'public' => null,
        'nome' => null,
        'guid' => null,
        'titolo' => null,
        'testo' => null,
        'main_img_id' => null,
        'alt_img_id' => null,
        'seo_title' => null,
        'seo_description' => null,
        'seo_keyword' => null,
        'extra_field' => null,
        'gallery' => null,
        'json_data' => null,
	];
}
