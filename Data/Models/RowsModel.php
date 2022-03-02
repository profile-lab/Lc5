<?php

namespace Lc5\Data\Models;

use stdClass;

class RowsModel extends MasterModel
{
	protected $table                = 'rows';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\Row';
	protected $allowedFields        = [
		'id',
		// 'status',
		'id_app',
		'lang',
		'modulo',
		'parent',
		'master_row',
		'ordine',
		'type',
		'nome',
		'titolo',
		'sottotitolo',
		'testo',
		// 
		'main_img_id',
		'alt_img_id',
		'css_class',
		'css_color',
		'css_extra_class',
		'cta_url',
		'cta_label',
		'extra_field',
		'custom_field',
		'gallery',

		'json_data',

		'component',
		'component_params',
		'video_url',
		//
		'free_values',
		'formato_media',
	];

	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
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
		if ($data['singleton'] == true) {
			$data['data'] = $this->extendData($data['data']);
		} else {
			foreach ($data['data'] as $item) {
				$item = $this->extendData($item);
			}
		}
		return $data;
	}

	private function extendData($item)
	{
		if ($item) {

			$media_model = new MediaModel();
			$item->main_img_obj = NULL;
			$item->main_img_path = NULL;
			$item->alt_img_obj = NULL;
			$item->alt_img_path = NULL;
			// 
			$item->data_object = NULL;
			// 
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
			if (isset($item->json_data) && trim($item->json_data)) {
				$json_2_object = json_decode($item->json_data);
				if (json_last_error() === JSON_ERROR_NONE) {
					$data_arr = [];
					foreach ($json_2_object as $obj_item) {
						$obj_item->path = '';
						if ($obj_item->img_obj = $media_model->find($obj_item->img_id)) {
							$obj_item->path = $obj_item->img_obj->path;
							$obj_item->is_image = $obj_item->img_obj->is_image;
							$obj_item->img_type = $obj_item->img_obj->tipo_file;
							if ($obj_item->img_obj->is_image) {
								$obj_item->img_thumb = 'uploads/thumbs/' . $obj_item->img_obj->path;
							} else {
								if ($obj_item->img_obj->tipo_file == 'svg') {
									$obj_item->img_thumb = ('uploads/' . $obj_item->img_obj->path);
								} else {
									$obj_item->img_thumb = $media_model->getThumbForType($obj_item->img_obj->tipo_file);
								}
							}
						}
						$data_arr[] = $obj_item;
						// dd($json_2_object);
					}
					$item->data_object = $data_arr;
					// dd($item->data_object);
				}
			}
			// 
			if ($item->type == 'component' && isset($item->component) && trim($item->component)) {
				$rows_components_model = new RowcomponentsModel();
				$item->dynamic_component = $rows_components_model->where('val', $item->component)->asObject()->first();
			}
			// 
			$item->free_values_object = [];
			if (isset($item->free_values) && trim($item->free_values)) {
				$free_values_2_object = json_decode($item->free_values);
				if (json_last_error() === JSON_ERROR_NONE) {
					$free_values_arr = [];
					foreach ($free_values_2_object as $free_values_item) {
						$free_values_item_data = new stdClass();
						$free_values_item_data->key = $free_values_item->key;
						$free_values_item_data->value = $free_values_item->value;
						$free_values_arr[] = $free_values_item_data;
						// dd($json_2_object);
					}
					$item->free_values_object = $free_values_arr;
					// dd($item->data_object);
				}
			}
		}
		// 
		return $item;
	}

	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		return $data;
	}
}
