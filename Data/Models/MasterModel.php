<?php

namespace Lc5\Data\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{
	public $is_for_frontend 		= false;

	protected $DBGroup              = 'default';
	// protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $useSoftDelete        = TRUE;
	protected $protectFields        = TRUE;
	protected $useTimestamps        = TRUE;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';
	// Validation
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = TRUE;



	//----------------------------------------------------------------
	public function setForFrontemd($_is_for_frontend = true)
	{
		$this->is_for_frontend = $_is_for_frontend;
	}

	//----------------------------------------------------------------
	protected function checkAppAndLang()
	{
		// d(__locale__);
		// d(__web_app_id__);
		// d(__locale_uri__);


		$curr_lang = defined('__locale__') ? __locale__ : session()->get('curr_lc_lang');
		$curr_app = defined('__web_app_id__') ? __web_app_id__ : session()->get('curr_lc_app');

		// if (in_array('lang', $this->allowedFields)) {
		// 	if ($curr_lc_lang = session()->get('curr_lc_lang')) {
		// 		$this->where('lang', $curr_lc_lang);
		// 	}
		// }
		// if (in_array('id_app', $this->allowedFields)) {
		// 	if ($curr_lc_app = session()->get('curr_lc_app')) {
		// 		$this->where('id_app', $curr_lc_app);
		// 	}
		// }
		if (in_array('lang', $this->allowedFields)) {
			if (isset($curr_lang) && $curr_lang != null && $curr_lang != '') {
				$this->where('lang', $curr_lang);
			}
		}
		if (in_array('id_app', $this->allowedFields)) {
			if ($curr_app) {
				$this->where('id_app', $curr_app);
			}
		}
	}

	//----------------------------------------------------------------
	public function myModelHasChanged($__curr_entity)
	{
		$has_changed = false;
		foreach($this->allowedFields as $field) {			
			if ($__curr_entity->hasChanged($field)) {
				$has_changed = true;
				break;
			}
		}
		return $has_changed;
	}

	//----------------------------------------------------------------
	protected function setDataAppAndLang($data)
	{
		if ($this->is_for_frontend) {

			$curr_lang = defined('__locale__') ? __locale__ : session()->get('curr_lc_lang');
			$curr_app = defined('__web_app_id__') ? __web_app_id__ : session()->get('curr_lc_app');

			if (in_array('lang', $this->allowedFields)) {
				if (isset($curr_lang) && $curr_lang != null && $curr_lang != '') {
					if (isset($data['data']['lang'])) {
						// dd($data['data']);
					} else {
						$data['data']['lang'] = $curr_lang;
					}
				}
			}
			if (in_array('id_app', $this->allowedFields)) {
				if ($curr_app) {
					$data['data']['id_app'] = $curr_app;
				}
			}
		} else {
			if (in_array('lang', $this->allowedFields)) {
				if ($curr_lc_lang = session()->get('curr_lc_lang')) {
					if (isset($data['data']['lang'])) {
						// dd($data['data']);
					} else {
						$data['data']['lang'] = $curr_lc_lang;
					}
				}
			}
			if (in_array('id_app', $this->allowedFields)) {
				if ($curr_lc_app = session()->get('curr_lc_app')) {
					$data['data']['id_app'] = $curr_lc_app;
				}
			}
		}
		return $data;
	}
}
