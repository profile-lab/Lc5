<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Rowcomponent extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => null,
		'nome' => null,
		'val' => null,
		'type' => null,
		'view' => null,
		'before_func' => null,
		'before_func_params' => null,
		'after_func' => null,
		'after_func_param' => null,

	];
}
