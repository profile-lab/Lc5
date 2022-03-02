<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Pagestype extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => 1,
		'nome' => null,
		'val' => '',
	];

}
