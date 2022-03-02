<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class ShopAliquota extends Entity
{
	protected $attributes = [
        'id' => null,
        'id_app' => null,
        'nome' => null,
        'val' => null,
        'is_default' => null,
	];
}


