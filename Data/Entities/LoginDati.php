<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class LoginDati extends Entity
{
	protected $attributes = [
		'email' => null, // varchar(150) DEFAULT NULL,
		'password' => null, // varchar(255) DEFAULT NULL,
    ];
}
