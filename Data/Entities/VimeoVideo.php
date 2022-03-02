<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class VimeoVideo extends Entity
{
	protected $attributes = [
		'id' => null, // int(11) unsigned NOT NULL AUTO_INCREMENT,
		'status' => 1, // tinyint(1) DEFAULT '1',
		'id_app' => 1, // int(11) DEFAULT NULL,
		'lang' => null, // varchar(25) DEFAULT NULL,
		
        
        'vimeo_id' => null,
        'vimeo_path' => null,
        'video_path' => null,
        'nome' => null,
        'guid' => null,
        'titolo' => null,
        'thumb_path' => null,
        'cover_path' => null,
        'vimeo_video_status' => null,
        'vimeo_upload_form_action' => null,
        'vimeo_upload_form_code' => null,
        'vimeo_size' => null,



	
	];

}
