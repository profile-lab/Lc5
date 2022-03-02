<?php

namespace Lc5\Data\Models;

class MenusModel extends  MasterModel
{
	protected $table                = 'sitemenus';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\MenuItem';
	protected $allowedFields        = [
		'id',
		'id_app',
		'lang',
		'nome',
		'json_data',
	];


	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = ['beforeFind'];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		return $data;
	}
	protected function beforeFind(array $data)
	{
		$this->checkAppAndLang();
	}
}
