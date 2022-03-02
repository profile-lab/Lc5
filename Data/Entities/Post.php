<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Post extends Entity
{
	protected $attributes = [
		'status' => null,
		'id_app' => null,
		'lang' => null,
		'parent' => null,
		'ordine' => null,
		'public' => null,
		'is_evi' => null,
		'post_type' => null,
		'category' => null,
		'multi_categories' => null,
		'tags' => null,
		'nome' => null,
		'guid' => null,
		'titolo' => null,
		'sottotitolo' => null,
		'testo_breve' => null,
		'testo' => null,
		'main_img_id' => null,
		'alt_img_id' => null,
		'video_url' => null,
		'link_esterno' => null,
		'seo_title' => null,
		'seo_description' => null,
		'seo_keyword' => null,
		'extra_field' => null,
		'custom_field' => null,
		'gallery' => null,
		'json_data' => null,

		'entity_free_values' => null,

		'data_pub' => null,
		'data_evento' => null,

		'vimeo_video_id' => null,
        'vimeo_video_url' => null,
	];
}
