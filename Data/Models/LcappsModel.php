<?php

namespace Lc5\Data\Models;

class LcappsModel extends MasterModel
{
	protected $table                = 'lcapps';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\Lcapp';
	protected $allowedFields        = [
		'id',
		'nome',
		'apikey',
		'domain',
		'status',
		'is_in_maintenance_mode',
		// 'email', 
		// 'phone', 
		// 'address', 
		// 'piva', 
		// 'copy', 
		// 'app_description', 
		// 'facebook', 
		// 'instagram', 
		// 'twitter', 
		// 'maps', 
		// 'shop', 
		// 'seo_title', 
		// 'app_claim',

		'labels_json_object',
	];

	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = ['afterFind'];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];


	protected function afterFind(array $data)
	{
		// $data = $this->beforeSave($data);
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
			$curr_lang = defined('__locale__') ? __locale__ : session()->get('curr_lc_lang');
			$item->labels = [];
			if (isset($item->labels_json_object) && trim($item->labels_json_object)) {
				$labels_object = json_decode($item->labels_json_object);
				if (json_last_error() === JSON_ERROR_NONE) {
					$app_labels_arr = [];
					foreach ($labels_object as $key => $values) {
						foreach ($values as $lang_key => $lang_val) {
							if ($lang_key == $curr_lang) {
								$app_labels_arr[$key] = $lang_val;
							}
						}
					}
					$item->labels = $app_labels_arr;
				}
			}
		}
		return $item;
	}
	// 

	protected function beforeInsert(array $data)
	{
		$data['data']['apikey'] = bin2hex(random_bytes(4)) . '-' . bin2hex(random_bytes(10)) . '-' . bin2hex(random_bytes(4)) . '-' . bin2hex(random_bytes(4));
		return $data;
	}

	public function getAppLanguages($app_id)
	{
		$languages_model = new LanguagesModel();
		$app_languages = $languages_model->allowCallbacks(FALSE)->where('id_app', $app_id)->asObject()->findAll();
		return $app_languages;
	}
}
