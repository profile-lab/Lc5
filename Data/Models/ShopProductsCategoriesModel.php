<?php

namespace Lc5\Data\Models;

class ShopProductsCategoriesModel  extends MasterModel
{
	protected $table                = 'shop_products_categories';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\ShopProductsCategory';
	protected $allowedFields        = [
		'id_app',
		'lang',
		'parent',
		'ordine',
		'public',
		'nome',
		'guid',
		'titolo',
		'testo',
		'main_img_id',
		'alt_img_id',
		'seo_title',
		'seo_description',
		'seo_keyword',
		'extra_field',
		'gallery',
		'json_data',

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

	private function beforeSave(array $data)
	{
		if (!isset($data['data']['nome'])) {
			return $data;
		}
		$data['data']['guid'] = url_title($data['data']['nome'], '-', TRUE);
		return $data;
	}
}
