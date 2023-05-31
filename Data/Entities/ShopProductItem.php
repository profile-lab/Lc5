<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class ShopProductItem extends Entity
{
	protected $attributes = [
		'status' => null,
		'id_app' => null,
		'lang' => null,
		'parent' => 0,
		'ordine' => null,
		'public' => null,
		'is_evi' => null,
		'product_type' => null,
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
		'seo_title' => null,
		'seo_description' => null,
		'seo_keyword' => null,
		'extra_field' => null,
		'custom_field' => null,
		'gallery' => null,
		'json_data' => null,

		'price' => null,
		'ali' => 22,
		'giacenza' => 0,
		'um' => 'PZ',

		'entity_free_values' => null,

		'promo_price' => null,
		'discount_perc' => 0,
		'promo_mess' => null,
		'in_promo' => null,

		'scheda_tecnica' => null,
		'misura' => null,
		'colore' => null,
		'modello' => null,
		'stile' => null,
		'barcode' => null,
		'sku' => null,
		'fornitore' => null,
		'gruppo_merceologico' => null,



	];
}
