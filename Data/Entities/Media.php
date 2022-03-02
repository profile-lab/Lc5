<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Media extends Entity
{
	protected $attributes = [
		'id' => null, // int(11) unsigned NOT NULL AUTO_INCREMENT,
		'status' => 1, // tinyint(1) DEFAULT '1',
		'id_app' => null, // int(11) DEFAULT NULL,
		// 'lang' => null, // varchar(25) DEFAULT NULL,
		'ordine' => null, // int(11) DEFAULT '500',
		'public' => 1, // tinyint(1) DEFAULT '0',
		'nome' => null, // varchar(200) DEFAULT NULL,
		'guid' => null, // varchar(200) DEFAULT NULL,
		'path' => null, // varchar(200) DEFAULT NULL,
		'tipo_file' => null, // varchar(50) DEFAULT NULL,
		'mime' => null, // varchar(50) DEFAULT NULL,
		'is_image' => null, // tinyint(1) DEFAULT '0',
		'image_width' => null, // int(5) DEFAULT NULL,
		'image_height' => null, // int(5) DEFAULT NULL,
	
	];

}
