<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Language extends Entity
{
	protected $attributes = [
        'id' => null, // int(11) unsigned NOT NULL AUTO_INCREMENT,
        'id_app' => 1, // int(11) DEFAULT NULL,
		'nome' => null,
		'val' => null,
		'is_default' => 0,
    ];
}
