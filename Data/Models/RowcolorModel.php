<?php

namespace Lc5\Data\Models;

class RowcolorModel extends MasterModel
{
	protected $table                = 'rowscolors';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Rowscolor';
	protected $allowedFields        = [
		'id',
		'id_app',
		'nome',
		'val',
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
