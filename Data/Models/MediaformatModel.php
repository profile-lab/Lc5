<?php

namespace Lc5\Data\Models;

class MediaformatModel extends MasterModel
{
	protected $table                = 'mediaformats';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Mediaformat';
	protected $allowedFields        = [
		'id',
		'id_app',
		'nome',
		'folder',
		'rule',
		'w',
		'h',
    ];

	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = ['beforeFind'];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function beforeFind(array $data)
	{
		$this->checkAppAndLang();
	}
	
	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		return $data;
	}
}
