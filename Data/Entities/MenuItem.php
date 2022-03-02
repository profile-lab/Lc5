<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class MenuItem extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => 1,
		'lang' => null,
		'nome' => null,
		'json_data' => null,


	];
}
