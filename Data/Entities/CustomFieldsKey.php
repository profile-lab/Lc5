<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class CustomFieldsKey extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => null,
		'nome' => null,
        'val' => null,
        'type' => null,
        'target' => null,
    ];
}
