<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Page extends Entity
{
    protected $attributes = [
        'id' => null, // int(11) unsigned NOT NULL AUTO_INCREMENT,
        'status' => null, // tinyint(1) DEFAULT '1',
        'id_app' => null, // int(11) DEFAULT NULL,
        'lang' => null, // varchar(25) DEFAULT NULL,
        'parent' => 0, // int(11) DEFAULT NULL,
        'ordine' => 500, // int(11) DEFAULT '500',
        'public' => 1, // tinyint(1) DEFAULT '0',
        'is_home' => 0, // tinyint(1) DEFAULT '0',
        'type' => null, // varchar(100) DEFAULT NULL,
        'nome' => null, // varchar(200) DEFAULT NULL,
        'guid' => null, // varchar(200) DEFAULT NULL,
        'titolo' => null, // varchar(255) DEFAULT NULL,
        'main_img_id' => null, // varchar(255) DEFAULT NULL,
        'alt_img_id' => null, // varchar(255) DEFAULT NULL,
        'seo_title' => null, // varchar(255) DEFAULT NULL,
        'seo_description' => null, // varchar(255) DEFAULT NULL,
        'seo_keyword' => null, // varchar(150) DEFAULT NULL,
        'is_posts_archive' => null, // varchar(150) DEFAULT NULL,

        'entity_free_values' => null, // varchar(150) DEFAULT NULL,

        'vimeo_video_id' => null,
        'vimeo_video_url' => null,

    ];
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];
}
