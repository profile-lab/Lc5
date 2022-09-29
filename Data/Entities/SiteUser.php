<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class SiteUser extends Entity
{
	protected $attributes = [
        'id' => null, // int(11) unsigned NOT NULL AUTO_INCREMENT,
		'status' => 0, // tinyint(1) DEFAULT '0',
		'email' => null, // varchar(150) DEFAULT NULL,
		'password' => null, // varchar(255) DEFAULT NULL,
		'token' => null, // varchar(255) DEFAULT NULL,
		'name' => null, // varchar(100) DEFAULT NULL,
		'surname' => null, // varchar(100) DEFAULT NULL,
		'id_app' => 0, // int(11) DEFAULT NULL,

		'role' => 'APP-USER',
        'permissions' => '{}',
        'profili_attivi' => 0,
        'last_login' => null,

        'cf' => null,
		'piva' => null,
		'address' => null,
		'city' => null,
		'cap' => null,
		'tel_num' => null,

		't_e_c' => 0,
		'autorizzo_1' => 0,
		'autorizzo_2' => 0,
		'autorizzo_3' => 0,
		'autorizzo_4' => 0,
		'autorizzo_5' => 0,

		'activation_token' => null,
        'activated_at' => null,

    ];
	protected $datamap = [];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
}
