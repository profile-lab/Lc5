<?php

namespace Lc5\Data\Models;

class ShopProductsModel extends MasterModel
{

	public $shop_settings = null;

	protected $table                = 'shop_products';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\ShopProductItem';
	protected $allowedFields        = [
		'status',
		'id_app',
		'lang',
		'parent',
		'ordine',
		'public',
		'is_evi',
		'product_type',
		'category',
		'multi_categories',
		'tags',
		'nome',
		'guid',
		'titolo',
		'sottotitolo',
		'testo_breve',
		'testo',
		'main_img_id',
		'alt_img_id',
		'seo_title',
		'seo_description',
		'seo_keyword',
		'extra_field',
		'custom_field',
		'gallery',
		'json_data',

		'price',
		'ali',
		'giacenza',
		'um',

		'entity_free_values',

		'promo_price',
		'discount_perc',
		'promo_mess',

		'in_promo',
		'scheda_tecnica',
		'misura',
		'colore',
		'modello',
		'stile',
		'barcode',
		'sku',
		'fornitore',
		'gruppo_merceologico',

	];

	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = ['beforeUpdate'];
	protected $afterUpdate          = [];
	protected $beforeFind           = ['beforeFind'];
	protected $afterFind            = ['afterFind'];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function beforeFind(array $data)
	{
		$this->checkAppAndLang();
	}
	protected function afterFind(array $data)
	{
		// d($data);
		// $data = $this->beforeSave($data);
		if ($data['singleton'] == true) {
			$data['data'] = $this->extendData($data['data'], true);
		} else {
			foreach ($data['data'] as $item) {
				$item = $this->extendData($item);
			}
		}
		return $data;
	}

	private function extendData($item, $is_singleton = false)
	{
		if ($item) {

			if (isset($item->price)) {
				$this->dettaglioPrezzi($item);
			}
			$item->full_nome_prodotto = '';
			if (isset($item->titolo)) {
				// $item->full_nome_prodotto = $item->titolo . ( isset($item->modello) && trim($item->modello)) ? ' '. $item->modello : '';
				$item->full_nome_prodotto = $item->titolo . ' ' . $item->modello ;
				// d($item->full_nome_prodotto);
			}

			// 
			$media_model = new MediaModel();
			$item->main_img_obj = NULL;
			$item->main_img_path = NULL;
			$item->alt_img_obj = NULL;
			$item->alt_img_path = NULL;
			if (isset($item->main_img_id) && $item->main_img_id > 0) {
				if ($item->main_img_obj = $media_model->find($item->main_img_id)) {
					$item->main_img_path = $item->main_img_obj->path;
					$item->main_img_is_image = $item->main_img_obj->is_image;
					$item->main_img_type = $item->main_img_obj->tipo_file;
					if ($item->main_img_obj->is_image) {
						$item->main_img_thumb = 'uploads/thumbs/' . $item->main_img_obj->path;
					} else {
						if ($item->main_img_obj->tipo_file == 'svg') {
							$item->main_img_thumb = ('uploads/' . $item->main_img_obj->path);
						} else {
							$item->main_img_thumb = $media_model->getThumbForType($item->main_img_obj->tipo_file);
						}
					}
				}
			}
			if (isset($item->alt_img_id) && $item->alt_img_id > 0) {
				if ($item->alt_img_obj = $media_model->find($item->alt_img_id)) {
					$item->alt_img_path = $item->alt_img_obj->path;
					$item->alt_img_is_image = $item->alt_img_obj->is_image;
					$item->alt_img_type = $item->alt_img_obj->tipo_file;
					if ($item->alt_img_obj->is_image) {
						$item->alt_img_thumb = 'uploads/thumbs/' . $item->alt_img_obj->path;
					} else {
						if ($item->main_img_obj->tipo_file == 'svg') {
							$item->alt_img_thumb = ('uploads/' . $item->alt_img_obj->path);
						} else {
							$item->alt_img_thumb = $media_model->getThumbForType($item->alt_img_obj->tipo_file);
						}
					}
				}
			}
			// 
			$item->gallery_obj = NULL;
			if (isset($item->gallery) && trim($item->gallery)) {
				$gallery_obj_from_json = json_decode($item->gallery);
				$updated_gallery_json = '{';
				$gallery_obj = [];
				$conta_trovati = 0;
				foreach ($gallery_obj_from_json as $key => $val) {
					$c_gall_media_id = str_replace('i@', '', $key);
					if ($c_gall_media = $media_model->find($c_gall_media_id)) {
						$updated_gallery_json .= (($conta_trovati > 0) ? ',' : '') . '"' . $key . '":"' . site_url('uploads/thumbs/' . $c_gall_media->path) . '"';
						$gallery_obj[$key] = (object)['id' => $c_gall_media_id, 'src' => $c_gall_media->path];
						$gallery_obj[$key]->is_image =  $c_gall_media->is_image;
						$gallery_obj[$key]->type =  $c_gall_media->tipo_file;
						if ($c_gall_media->is_image) {
							$gallery_obj[$key]->thumb = 'uploads/thumbs/' . $c_gall_media->path;
						} else {
							if ($c_gall_media->tipo_file == 'svg') {
								$gallery_obj[$key]->thumb = ('uploads/' . $c_gall_media->path);
							} else {
								$gallery_obj[$key]->thumb = $media_model->getThumbForType($c_gall_media->tipo_file);
							}
						}
						$conta_trovati++;
					}
					// $gallery_obj[$key] = (object) ['id' => str_replace('i@','', $key), 'src' => $val ];
				}
				$item->gallery_obj = $gallery_obj;
				$updated_gallery_json .= '}';
				$item->gallery = $updated_gallery_json;
			}
			// 
			// 
			$item->entity_free_values_object = [];
			if (isset($item->entity_free_values) && trim($item->entity_free_values)) {
				$entity_free_values_2_object = json_decode($item->entity_free_values);
				if (json_last_error() === JSON_ERROR_NONE) {
					$entity_free_values_arr = [];
					foreach ($entity_free_values_2_object as $entity_free_values_item) {
						$entity_free_values_item_data = new \stdClass();
						$entity_free_values_item_data->key = $entity_free_values_item->key;
						$entity_free_values_item_data->value = $entity_free_values_item->value;
						$entity_free_values_arr[$entity_free_values_item->key] = $entity_free_values_item_data;
						// dd($json_2_object);
					}
					$item->entity_free_values_object = $entity_free_values_arr;
					// dd($item->entity_free_values_object);
				}
			}
			// 
			if (isset($item->tags) && $item->tags && trim($item->tags) ) // && isJson($item->tags)) 
			{
				$item->tags = json_decode($item->tags);
				if( json_last_error() !== JSON_ERROR_NONE ){
					$item->tags = [];
				}


				// $item->tags = json_decode($item->tags);
			} else {
				$item->tags = [];
			}
			// 
			// if (isset($item->misura ) && $item->misura && trim($item->misura) && isJson($item->misura)) {
			// 	$item->misura = json_decode($item->misura);
			// } else {
			// 	$item->misura = [];
			// }
			// 
			// if (isset($item->colore) && $item->colore && trim($item->colore) && isJson($item->colore)) {
			// 	$item->colore = json_decode($item->colore);
			// } else {
			// 	$item->colore = [];
			// }
			// 
			// 
			if ($this->is_for_frontend) {
				if ($is_singleton) {
					if (isset($item->seo_title) && !trim($item->seo_title)) {
						if (isset($item->titolo) && trim($item->titolo)) {
							$item->seo_title = $item->titolo;
						}else if (isset($item->nome) && trim($item->nome)) {
							$item->seo_title = $item->nome;
						}
					}
					if (isset($item->seo_description) && !trim($item->seo_description)) {
						if (isset($item->titolo) && trim($item->titolo)) {
							$item->seo_description = $item->titolo;
						}else if (isset($item->nome) && trim($item->nome)) {
							$item->seo_description = $item->nome;
						}
					}
				}
			}

		}
		return $item;
	}

	protected function beforeUpdate(array $data)
	{
		$data = $this->beforeSave($data);
		return $data;
	}
	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		$data = $this->beforeSave($data);
		return $data;
	}

	// private function beforeSave(array $data)
	// {
	// 	if (!isset($data['data']['nome'])) {
	// 		return $data;
	// 	}
	// 	$data['data']['guid'] = url_title($data['data']['nome'], '-', TRUE);
	// 	return $data;
	// }



	private function beforeSave(array $data)
	{
		// dd($data);
		$curr_item_lang = null;
		if (in_array('lang', $this->allowedFields)) {
			if ($curr_lc_lang = session()->get('curr_lc_lang')) {
				$curr_item_lang = $curr_lc_lang;
			}
		}
		if (isset($data['data']['guid'])) {
			$data['data']['guid'] = url_title($data['data']['guid'], '-', TRUE);
			$data['data']['guid'] = $this->chechIsUnique($data['data']['guid'], $curr_item_lang, (isset($data['id'])) ? $data['id'] : null);
		} else if (isset($data['data']['nome'])) {
			$data['data']['guid'] = url_title($data['data']['nome'], '-', TRUE);
			$data['data']['guid'] = $this->chechIsUnique($data['data']['guid'], $curr_item_lang, (isset($data['id'])) ? $data['id'] : null);
			if (isset($data['data']['titolo']) && trim($data['data']['titolo']) == '') {
				$data['data']['titolo'] = $data['data']['nome'];
			}
		}
		// 
		if (isset($data['data']['in_promo'])) {
			$data['data']['in_promo'] = 1;
		} else {
			$data['data']['in_promo'] = 0;
		}
		// 
		return $data;
	}

	private function chechIsUnique($guid, $lang = null,  $exclude_id = null)
	{
		$count = null;
		while (!$new_guid = $this->chechIsUniqueRun($guid, $count, $lang, $exclude_id)) {
			if ($count) {
				$count++;
			} else {
				$count = 2;
			}
		}
		return $new_guid;
	}
	private function chechIsUniqueRun($guid, $count = null, $lang = null, $exclude_id = null)
	{
		if ($count) {
			$guid .= '-' . $count;
		}
		$is_unique_qb = $this->allowCallbacks(FALSE)->select('id, guid')->where('guid', $guid);
		if ($lang) {
			$is_unique_qb->where('lang', $lang);
		}
		if ($exclude_id) {
			$is_unique_qb->where('id !=', $exclude_id);
		}
		if ($is_unique_qb->first()) {
			return FALSE;
		}
		return $guid;
	}


	//-------------------------------------------------

	public function extendModelByParent(&$product, $select = null)
	{
		if (!$parent_prod = $this->asObject()->where('id', $product->parent)->first()) {
			return FALSE;
		}

		// $product->full_nome_prodotto = $parent_prod->titolo . (trim($product->modello)) ? ' '. $product->modello : '';

		$product->prod_id = $parent_prod->id;
		$product->prod_model_id = $product->id;
		// 
		$product->category = $parent_prod->category;
		if ($product->category > 0) {
			$shop_products_cat_model = new ShopProductsCategoriesModel();
			$category_obj_qb = $shop_products_cat_model->asObject()->where('id', $product->category);
			if ($select == 'min') {
				$category_obj_qb->select(['id', 'nome', 'titolo', 'guid']);
			}
			if ($product->category_obj = $category_obj_qb->first()) {
				$product->category_obj->permalink = route_to(__locale_uri__ . 'web_shop_category', $product->category_obj->guid);
			}
		} else {
			$product->category_obj = null;
		}
		// 

		if ($product->price < 0.01) {
			$product->price = $parent_prod->price;
			$product->iva = $parent_prod->iva;
			$product->promo_price = $parent_prod->promo_price;
			$product->discount_perc = $parent_prod->discount_perc;
		}
		$this->dettaglioPrezzi($product);


		// // MODELLI 
		$modelli_qb = $this->asObject()->where('parent', $parent_prod->id);
		if ($select == 'min') {
			$modelli_qb->select(['id', 'nome', 'titolo', 'modello', 'giacenza', 'guid', 'price', 'promo_price', 'ali']);
		}
		$product->has_modelli = FALSE;
		// 
		$models_list = [];
		$modello_base = (object) [
			'ali' => $parent_prod->ali,
			'alt_img_obj' => $parent_prod->alt_img_obj,
			'alt_img_path' => $parent_prod->alt_img_path,
			'entity_free_values_object' => $parent_prod->entity_free_values_object,
			'gallery_obj' => $parent_prod->gallery_obj,
			'guid' => $parent_prod->guid,
			'id' => $parent_prod->id,
			'main_img_obj' => $parent_prod->main_img_obj,
			'main_img_path' => $parent_prod->main_img_path,
			'nome' => $parent_prod->nome,
			'tags' => $parent_prod->tags,
			'titolo' => $parent_prod->titolo,
			'modello' => (trim($parent_prod->modello)) ? $parent_prod->modello : $parent_prod->nome,

			'full_nome_prodotto' => $parent_prod->titolo . ' ' . $parent_prod->modello,


			'giacenza' => $parent_prod->giacenza,

			'price' => $parent_prod->price,
			'iva' => $parent_prod->iva,
			'promo_price' => $parent_prod->promo_price,
			'discount_perc' => $parent_prod->discount_perc,

			'permalink' => route_to(__locale_uri__ . 'web_shop_detail', $parent_prod->guid)

		];
		$this->dettaglioPrezzi($modello_base);
		$models_list[] = $modello_base;
		// 
		if ($modelli = $modelli_qb->findAll()) {

			foreach ($modelli as $modello) {
				if ($modello->price < 0.01) {
					$modello->price = $modello_base->price;
					$modello->iva = $modello_base->iva;
					$modello->promo_price = $modello_base->promo_price;
					$modello->discount_perc = $modello_base->discount_perc;
				}
				$this->dettaglioPrezzi($modello);
				// 
				$modello->permalink = route_to(__locale_uri__ . 'web_shop_detail_model', $product->guid, $modello->id);
				$modello->full_nome_prodotto = $modello->titolo . ' ' . $modello->modello;

				// 
				$models_list[] = $modello;
			}
			$product->has_modelli = TRUE;
		}
		$product->modelli = $models_list;

	}


	//-------------------------------------------------

	public function extendProduct(&$product, $select = null)
	{

		// $product->full_nome_prodotto = $product->titolo . (trim($product->modello)) ? ' '. $product->modello : '';

		$product->prod_id = (isset($product->parent) && $product->parent > 0) ? $product->parent : $product->id;
		$product->prod_model_id = $product->id;
		// 
		if ($product->category > 0) {
			$shop_products_cat_model = new ShopProductsCategoriesModel();
			$category_obj_qb = $shop_products_cat_model->asObject()->where('id', $product->category);
			if ($select == 'min') {
				$category_obj_qb->select(['id', 'nome', 'titolo', 'guid']); 
			}
			if ($product->category_obj = $category_obj_qb->first()) {
				$product->category_obj->permalink = route_to(__locale_uri__ . 'web_shop_category', $product->category_obj->guid);
			}
		} else {
			$product->category_obj = null;
		}


		// // MODELLI 
		$modelli_qb = $this->asObject()->where('parent', $product->id);
		if ($select == 'min') {
			$modelli_qb->select(['id', 'nome', 'titolo', 'modello', 'giacenza', 'guid', 'price', 'promo_price', 'ali']);
		}
		$product->has_modelli = FALSE;
		// 
		$models_list = [];
		$modello_base = (object) [
			'ali' => $product->ali,
			'alt_img_obj' => $product->alt_img_obj,
			'alt_img_path' => $product->alt_img_path,
			'entity_free_values_object' => $product->entity_free_values_object,
			'gallery_obj' => $product->gallery_obj,
			'guid' => $product->guid,
			'id' => $product->id,
			'main_img_obj' => $product->main_img_obj,
			'main_img_path' => $product->main_img_path,
			'nome' => $product->nome,
			'tags' => $product->tags,
			'titolo' => $product->titolo,
			'modello' => (trim($product->modello)) ? $product->modello : $product->nome,
			'full_nome_prodotto' => $product->titolo . ' ' . $product->modello,

			'giacenza' => $product->giacenza,

			'price' => $product->price,
			'iva' => $product->iva,
			'promo_price' => $product->promo_price,
			'discount_perc' => $product->discount_perc,

			'permalink' => route_to(__locale_uri__ . 'web_shop_detail', $product->guid)

		];
		$this->dettaglioPrezzi($modello_base);
		$models_list[] = $modello_base;
		// 
		if ($modelli = $modelli_qb->findAll()) {

			foreach ($modelli as $modello) {
				if ($modello->price < 0.01) {
					$modello->price = $modello_base->price;
					$modello->iva = $modello_base->iva;
					$modello->promo_price = $modello_base->promo_price;
					$modello->discount_perc = $modello_base->discount_perc;
				}
				$this->dettaglioPrezzi($modello);
				// 
				$modello->permalink = route_to(__locale_uri__ . 'web_shop_detail_model', $product->guid, $modello->id);
				$modello->full_nome_prodotto = $modello->titolo . ' ' . $modello->modello;

				// 
				$models_list[] = $modello;
			}
			$product->has_modelli = TRUE;
		}
		$product->modelli = $models_list;
		// // FINE MODELLI 
		// 
	}



	private function dettaglioPrezzi(&$item)
	{
		if ($item) {
			$imponibile = number_format($item->price, 2, '.', '');
			$aliquota_vat = 22;
			if (isset($item->ali)) {
				$aliquota_vat = $item->ali;
			}
			$iva = number_format((($imponibile * $aliquota_vat) / 100), 2, '.', '');
			// 
			$item->imponibile = $imponibile;
			$item->imponibile_pieno = $imponibile;
			$item->iva = $iva;
			$item->iva_pieno = $iva;
			$item->prezzo = number_format(($imponibile + $iva), 2, '.', '');
			$item->prezzo_pieno = $item->prezzo;
			$item->is_in_promo = FALSE;
			// 
			if (isset($this->shop_settings)) {
				if ($this->shop_settings->discount_type == 'PRICE') {
					if (isset($item->promo_price) && $item->promo_price > 0) {
						$imponibile = number_format($item->promo_price, 2, '.', '');
						$iva = number_format((($imponibile * $aliquota_vat) / 100), 2, '.', '');
						// 
						$item->imponibile = $imponibile;
						$item->iva = $iva;
						$item->prezzo = number_format(($imponibile + $iva), 2, '.', '');
						$item->is_in_promo = TRUE;
					}
				} elseif ($this->shop_settings->discount_type == 'PERCENTAGE') {
					$item->discount_perc;
				}
			}
			// 
			$item->imponibile_coin = '€ ' . number_format($item->imponibile, 2, ',', '.');
			$item->imponibile_pieno_coin = '€ ' . number_format($item->imponibile_pieno, 2, ',', '.');
			$item->iva_coin = '€ ' . number_format($item->iva, 2, ',', '.');
			$item->iva_pieno_coin = '€ ' . number_format($item->iva_pieno, 2, ',', '.');
			$item->prezzo_coin = '€ ' . number_format($item->prezzo, 2, ',', '.');
			$item->prezzo_pieno_coin = '€ ' . number_format($item->prezzo_pieno, 2, ',', '.');
			// $item->is_in_promo_coin = '€ ' . number_format($item->is_in_promo, 2, ',', '.');
		}
	}
}
