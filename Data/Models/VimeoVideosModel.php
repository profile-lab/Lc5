<?php

namespace Lc5\Data\Models;

class VimeoVideosModel extends MasterModel
{
	protected $table                = 'vimeo_videos';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'Lc5\Data\Entities\VimeoVideo';
	protected $allowedFields        = [
		'id',
		'status', // tinyint(1) DEFAULT '1',
		'id_app', // int(11) DEFAULT NULL,
		// 'lang', // varchar(25) DEFAULT NULL,
        'vimeo_id', // => null,
        'vimeo_path', // => null,
        'video_path', // => null,
        'nome', // => null,
        'guid', // => null,
        'titolo', // => null,
        'thumb_path', // => null,
        'cover_path', // => null,
        'vimeo_video_status', // => null,
        'vimeo_upload_form_action', // => null,
        'vimeo_upload_form_code', // => null,
        'vimeo_size', // => null,


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
		return $data;
	}

}
