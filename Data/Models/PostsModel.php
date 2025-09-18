<?php

namespace Lc5\Data\Models;

class PostsModel extends MasterModel
{
	protected $table                = 'posts';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\Post';
	protected $allowedFields        = [
		'id',
		'status',
		'id_app',
		'lang',
		'parent',
		'ordine',
		'public',
		'is_evi',
		'post_type',
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
		'video_url',
		'link_esterno',
		'seo_title',
		'seo_description',
		'seo_keyword',
		'extra_field',
		'custom_field',
		'gallery',
		'json_data',

		'entity_free_values',

		'data_pub',
		'data_evento',

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

	public function __construct()
	{
		parent::__construct();
		$db = \Config\Database::connect();
		if ($db->tableExists('posts')) {
			if ($db->fieldExists('media_static_file_url','posts')) {
				$this->allowedFields[] = 'media_static_file_url';
			}
		}
	}

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
			if (isset($item->media_static_file_url) && $item->media_static_file_url != '') {
				$item->media_static_file_complete_url = 'uploads/' . $item->media_static_file_url;
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
			if (isset($item->category) && $item->category > 0) {
				$category_model = new PostscategoriesModel(); 
				if($category = $category_model->select(['id', 'nome', 'guid','titolo'])->asObject()->find($item->category)){
					$item->category_object = $category;
				}
			}
			// 
			// $item->multi_categories = json_decode($item->multi_categories);
			$item->multi_categories = (isset($item->multi_categories) && $item->multi_categories && trim($item->multi_categories) && isJson($item->multi_categories)) ?  json_decode($item->multi_categories) : [];
			if (isset($item->tags) && $item->tags && trim($item->tags) && isJson($item->tags)) {
				$item->tags = json_decode($item->tags);
			} else {
				$item->tags = [];
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
						$updated_gallery_json .= (($conta_trovati > 0) ? ',' : '') . '"' . $key . '":"' . env('custom.media_root_path') . 'thumbs/' . $c_gall_media->path . '"';
						$gallery_obj[$key] = (object)['id' => $c_gall_media_id, 'src' => $c_gall_media->path];
						$gallery_obj[$key]->is_image =  $c_gall_media->is_image;
						$gallery_obj[$key]->type =  $c_gall_media->tipo_file;
						if ($c_gall_media->is_image) {
							$gallery_obj[$key]->thumb = env('custom.media_root_path') . 'thumbs/' . $c_gall_media->path;
						} else {
							if ($c_gall_media->tipo_file == 'svg') {
								$gallery_obj[$key]->thumb = env('custom.media_root_path') . $c_gall_media->path;
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
		// if (!isset($data['data']['nome'])) {
		//     return $data;
		// }
		// $data['data']['guid'] = url_title($data['data']['nome'], '-', TRUE);
		if (isset($data['data']['nome'])) {
			$curr_item_lang = null;
			if (in_array('lang', $this->allowedFields)) {
				if ($curr_lc_lang = session()->get('curr_lc_lang')) {
					$curr_item_lang = $curr_lc_lang;
				}
			}
			$data['data']['guid'] = url_title($data['data']['nome'], '-', TRUE);
			$data['data']['guid'] = $this->chechIsUnique($data['data']['guid'], $curr_item_lang, (isset($data['data']['id'])) ? $data['data']['id'] : null);
		}
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
}
