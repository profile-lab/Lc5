<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Rowsstyle extends Entity
{
	protected $attributes = [
		'id' => null,
		'id_app' => 1,
		'nome' => null,
		'val' => '',
		'type' => null,
		'ordine' => 500,

		'fields_config' => null,
		'extra_fields_config' => null,
	];
	public $rows_attributes = [
		'custom_fields_rows' => [
			'label' => 'Campi Custom',
			'name' => 'custom_fields_rows',
		],
		
		'cta_url' => [
			'label' => 'CTA',
			'name' => 'cta_url',
		],

		'cta_label' => [
			'label' => 'CTA Label',
			'name' => 'cta_label',
		],
		
		'css_color' => [
			'label' => 'Colori',
			'name' => 'css_color',
		],
		
		'formato_media' => [
			'label' => 'Formati Immagini',
			'name' => 'formato_media',
		],
		
		'immagine' => [
			'label' => 'Immagine',
			'name' => 'immagine',
		],
		
		'gallery' => [
			'label' => 'Gallery',
			'name' => 'gallery',
		],
		
		'css_extra_class' => [
			'label' => 'Stile Extra',
			'name' => 'css_extra_class',
		],
		
		'sottotitolo' => [
			'label' => 'Sottotitolo',
			'name' => 'sottotitolo',
		],
		'titolo' => [
			'label' => 'Titolo',
			'name' => 'titolo',
		],

		
		// 'alt_img_id' => [
		// 	'label' => 'Immagine secondaria',
		// 	'name' => 'alt_img_id',
		// ],


		
		'video_url' => [
			'label' => 'Video (URL)',
			'name' => 'video_url',
		],
		
		



	];
}
