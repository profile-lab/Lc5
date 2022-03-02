<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Row extends Entity
{
	protected $attributes = [
		'id' => null, // int(11) unsigned NOT NULL AUTO_INCREMENT,
		// 'status' => 1, // tinyint(1) DEFAULT '1',
		'id_app' => null, // int(11) DEFAULT NULL,
		'lang' => null, // varchar(25) DEFAULT NULL,
		'modulo' => null, // varchar(100) DEFAULT NULL,
		'parent' => null, // int(11) DEFAULT NULL,
		'master_row' => null, // int(11) DEFAULT NULL,
		'ordine' => '500', // int(11) DEFAULT '500',
		'type' => null, // varchar(100) DEFAULT NULL,
		'nome' => null, // varchar(200) DEFAULT NULL,
		'titolo' => null, // varchar(255) DEFAULT NULL,
		'sottotitolo' => null, // varchar(255) DEFAULT NULL,
		'testo' => null, // text,
		// 
		'main_img_id' => null, // int(11) DEFAULT NULL,
		'alt_img_id' => null, // int(11) DEFAULT NULL,
		'css_class' => null, // varchar(100) DEFAULT NULL,
		'css_color' => null, // varchar(100) DEFAULT NULL,
		'css_extra_class' => null, // varchar(100) DEFAULT NULL,
		'cta_url' => null, // varchar(255) DEFAULT NULL,
		'cta_label' => null, // varchar(255) DEFAULT NULL,
		'extra_field' => null, // varchar(255) DEFAULT NULL,
		'custom_field' => null, // varchar(255) DEFAULT NULL,
		'gallery' => null, // text,
		//
		'json_data' => null, // text,
		//
		'component' => null, // varchar(255) DEFAULT NULL,
		'component_params' => null, // varchar(255) DEFAULT NULL,
		'video_url' => null, // varchar(255) DEFAULT NULL,
		//
		'free_values' => null, // text,
		'formato_media' => null, // text,

	];
	// protected $datamap = [];
	// protected $dates   = [
	// 	'created_at',
	// 	'updated_at',
	// 	'deleted_at',
	// ];
	// protected $casts   = [];
}
