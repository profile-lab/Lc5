<?php

namespace Lc5\Data\Models;

use Lc5\Data\Models\MediaModel;

class PagesModel extends MasterModel
{

	protected $table                = 'pages';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\Page';
	protected $allowedFields        = [
		'id',
		'status',
		'id_app',
		'lang',
		'parent',
		'ordine',
		'public',
		'is_home',
		'type',
		'nome',
		'guid',
		'titolo',
		'main_img_id',
		'alt_img_id',
		'seo_title',
		'seo_description',
		'seo_keyword',
		'is_posts_archive',

		'entity_free_values',

		'vimeo_video_id',
		'vimeo_video_url',

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
		if($this->is_for_frontend == true){
			$this->where('status !=', 0);
			$this->where('public', 1);
		}
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
			// 
			$vimeo_video_model = new VimeoVideosModel();
			$item->vimeo_video_obj = NULL;
			if (isset($item->vimeo_video_id) && $item->vimeo_video_id != '') {
				$item->vimeo_video_obj = $vimeo_video_model->where('vimeo_id', $item->vimeo_video_id)->first();
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
						$item->main_img_thumb = env('custom.media_root_path') . 'thumbs/' . $item->main_img_obj->path;
					} else {
						if ($item->main_img_obj->tipo_file == 'svg') {
							$item->main_img_thumb = env('custom.media_root_path') . $item->main_img_obj->path;
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
						$item->alt_img_thumb = env('custom.media_root_path') . 'thumbs/' . $item->alt_img_obj->path;
					} else {
						if ($item->main_img_obj->tipo_file == 'svg') {
							$item->alt_img_thumb = env('custom.media_root_path') . $item->alt_img_obj->path;
						} else {
							$item->alt_img_thumb = $media_model->getThumbForType($item->alt_img_obj->tipo_file);
						}
					}
				}
			}

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
		$curr_item_lang = null;
		if (in_array('lang', $this->allowedFields)) {
			if ($curr_lc_lang = session()->get('curr_lc_lang')) {
				$curr_item_lang = $curr_lc_lang;
			}
		}
		if (isset($data['data']['guid'])) {
			$data['data']['guid'] = url_title($data['data']['guid'], '-', TRUE);
			$data['data']['guid'] = $this->chechIsUnique($data['data']['guid'], $curr_item_lang, (isset($data['data']['id'])) ? $data['data']['id'] : null);
		} else if (isset($data['data']['nome'])) {

			$data['data']['guid'] = url_title($data['data']['nome'], '-', TRUE);
			$data['data']['guid'] = $this->chechIsUnique($data['data']['guid'], $curr_item_lang, (isset($data['data']['id'])) ? $data['data']['id'] : null);
		}


		return $data;
	}

	private function chechIsUnique($guid, $lang = null, $exclude_id = null)
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
		$curr_app = defined('__web_app_id__') ? __web_app_id__ : session()->get('curr_lc_app');

		if ($count) {
			$guid .= '-' . $count;
		}
		$is_unique_qb = $this->allowCallbacks(FALSE)->select('id, guid')->where('guid', $guid);
		$is_unique_qb->where('id_app', $curr_app);
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

	// protected function passwordHash(array $data)
	// {
	// 	if (isset($data['data']['password'])) {
	// 		$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
	// 	}

	// 	return $data;
	// }
}
