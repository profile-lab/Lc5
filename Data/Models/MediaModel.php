<?php

namespace Lc5\Data\Models;

class MediaModel extends MasterModel
{
	protected $table                = 'medias';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\Media';
	protected $allowedFields        = [
		'id',
		'status', // tinyint(1) DEFAULT '1',
		'id_app', // int(11) DEFAULT NULL,
		// 'lang', // varchar(25) DEFAULT NULL,
		'ordine', // int(11) DEFAULT '500',
		'public', // tinyint(1) DEFAULT '0',
		'nome', // varchar(200) DEFAULT NULL,
		'guid', // varchar(200) DEFAULT NULL,
		'path', // varchar(200) DEFAULT NULL,
		'tipo_file', // varchar(50) DEFAULT NULL,
		'mime', // varchar(50) DEFAULT NULL,
		'is_image', // tinyint(1) DEFAULT '0',
		'image_width', // int(5) DEFAULT NULL,
		'image_height', // int(5) DEFAULT NULL,

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
			// $item->thumb = NULL;
			if (isset($item->path)) {
				$item->thumb = env('custom.media_root_path') . 'thumbs/' . $item->path;
			}
			//
			if (isset($item->is_image)) {
				if ($item->is_image) {
					// $item->img_thumb = site_url('uploads/thumbs/' . $item->path);
					$item->img_thumb =  env('custom.media_root_path') . 'thumbs/' . $item->path;
				} else {
					if ($item->tipo_file == 'svg') {
						// $item->img_thumb = site_url('uploads/' . $item->path);
						$item->img_thumb = env('custom.media_root_path') . $item->path;
					} else {
						$item->img_thumb = site_url($this->getThumbForType($item->tipo_file));
					}
				}
			}
		}
		//
		return $item;
	}

	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		$data = $this->beforeSave($data);
		return $data;
	}
	protected function beforeUpdate(array $data)
	{
		// $data = $this->beforeSave($data);
		return $data;
	}

	protected function beforeSave(array $data)
	{
		if (isset($data['data']['path'])) {
			$data['data']['guid'] = $data['data']['path'];
			if (!isset($data['data']['nome'])) {
				$data['data']['nome'] = $data['data']['path'];
			}
		}
		return $data;
	}

	public function getThumbForType($tipo_file = null)
	{
		$thumb_path = 'assets/lc-admin-assets/img/thumb-default.png';
		if ($tipo_file) {
			$thumb_path = 'assets/lc-admin-assets/img/thumb-' . $tipo_file . '.png';
		}
		return $thumb_path;
	}
}
