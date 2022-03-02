<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class ShopProductsTag extends Entity
{
	protected $attributes = [
        'id_app' => null,
        'lang' => null,
        'parent' => null,
        'post_type' => null,
        'ordine' => null,
        'public' => null,
        'nome' => null,
        'val' => null,
	];
}
