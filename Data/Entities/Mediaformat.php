<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Mediaformat extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => 1,
		'nome' => null,
		'folder' => '',
		'rule' => '',
		'w' => 0,
		'h' => 0,
		
	];
}
		