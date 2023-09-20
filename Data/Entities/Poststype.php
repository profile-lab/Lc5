<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Poststype extends Entity
{
	protected $attributes = [
		'id_app' => 1,
		'parent' => null,
		'nome' => null,
		'val' => '',
		'fields_config' => null,
		'extra_fields_config' => null,
		'has_paragraphs' => 0,
		'post_order' => 'id',
		'post_sort' => 'DESC',
		'post_per_page' => '24',

		'archive_root' => null,
		'has_archive' => 1,
		'has_custom_fields' => 0,
	];

	public $post_fix_attrs = [
		['name' => 'status', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'checkbox'],
		['name' => 'id_app', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'AUTO_APP'],
		['name' => 'lang', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'AUTO_APP'],
		// ['name' => 'ordine', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'number'],
		['name' => 'post_type', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'AUTO_APP'],
		['name' => 'nome', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'text'],
		['name' => 'guid', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'readonly'],
		['name' => 'titolo', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'text'],
		// ['name' => 'sottotitolo', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'text'],
		['name' => 'testo', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' => 'html-editor'],
		['name' => 'main_img_id', 'active' => true, 'w' => '12', 'view_side' => 'side',  'type' => 'img-single'],
		// ['name' => 'json_data', 'active' => true, 'w' => '12', 'view_side' => 'main',  'type' =>  'AUTO_APP'],

	];

	public $post_attributes = [
		'sottotitolo' => [
			'label' => 'Sottotitolo',
			'name' => 'sottotitolo',
			'w' => '12',
			'view_side' => 'FIX',
			'type' => 'text'
		],

		
		'testo_breve' => [
			'label' => 'Testo Breve',
			'name' => 'testo_breve',
			'w' => '12',
			'view_side' => 'main',
			'type' => 'html-editor'
		],

		'gallery' => [
			'label' => 'Gallery',
			'name' => 'gallery',
			'w' => '12',
			'view_side' => 'main',
			'type' => 'img-gallery',
			'gallery_obj' => 'gallery_obj'
		],

		'tags' => [
			'label' => 'Tags',
			'name' => 'tags',
			'w' => '12',
			'view_side' => 'main',
			'type' => 'tags',
			'sources' => 'poststype_tags_list',
		],

		
		'seo_title' => [
			'label' => 'SEO title',
			'name' => 'seo_title',
			'placeholder' => 'Titolo SEO (max 70 caratteri - consigliato 50 / 60)',
			'w' => '12',
			'view_side' => 'foot',
			'type' => 'text'
		],
		
		'seo_description' => [
			'label' => 'SEO description',
			'name' => 'seo_description',
			'placeholder' => 'SEO META DESCRIPTION (max 160 caratteri - consigliato 90 / 150)',
			'w' => '12',
			'view_side' => 'foot',
			'type' => 'text-area'
		],

		'seo_keyword' => [
			'label' => 'SEO keywords',
			'name' => 'seo_keyword',
			'w' => '12',
			'view_side' => 'foot',
			'type' => 'text'
		],


		'ordine' => [
			'label' => 'Ordine',
			'name' => 'ordine',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'number',
		],

		'is_evi' => [
			'label' => 'In Evidenza',
			'name' => 'is_evi',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'checkbox-bool',
		],
		// 'is_evi' => [
		// 	'label' => 'In Evidenza',
		// 	'name' => 'is_evi',
		// 	'w' => '12',
		// 	'view_side' => 'side',
		// 	'type' => 'select',
		// 	'sources' => 'bool_values',
		// 	'no_empty' => TRUE,
		// ],

		'data_pub' => [
			'label' => 'Data pubblicazione',
			'name' => 'data_pub',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'datetime',
		],
		'data_evento' => [
			'label' => 'Data evento',
			'name' => 'data_evento',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'datetime',
		],

		'alt_img_id' => [
			'label' => 'Immagine secondaria',
			'name' => 'alt_img_id',
			'w' => '12',
			'view_side' => 'FIX',
			'type' => 'img-single',
			'src_attr' => 'alt_img_path'
		],
		
		'link_esterno' => [
			'label' => 'Link Esterno',
			'name' => 'link_esterno',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'text'
		],
		'video_url' => [
			'label' => 'Video (URL)',
			'name' => 'video_url',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'video-url'
		],

		'category' => [
			'label' => 'Categoria',
			'name' => 'category',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'select',
			'sources' => 'poststype_categories_list',
		],
		'parent' => [
			'label' => 'Genitore',
			'name' => 'parent',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'select',
			'sources' => 'parents_list',

		],
		'multi_categories' => [
			'label' => 'Categorie',
			'name' => 'multi_categories',
			'w' => '12',
			'view_side' => 'side',
			'type' => 'select-multi',
			'sources' => 'poststype_categories_list',
		],
		
		


	];


	// protected $datamap = [];
	// protected $dates   = [
	// 	'created_at',
	// 	'updated_at',
	// 	'deleted_at',
	// ];
	// protected $casts   = [];
}
