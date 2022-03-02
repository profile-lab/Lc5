<?php

namespace Lc5\Data\Models;

use CodeIgniter\Model;

class RowcomponentsModel extends MasterModel
{
	protected $table                = 'rowcomponents';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Rowcomponent';
	protected $allowedFields        = [
		'id',
		'id_app',
		'nome',
		'val',
		'type',
		'view',
		'before_func',
		'before_func_params',
		'after_func',
		'after_func_param',
	];
	
	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = ['beforeUpdate'];
	protected $afterUpdate          = [];
	protected $beforeFind           = ['beforeFind'];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function beforeFind(array $data)
	{
		$this->checkAppAndLang();
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
		
        if (isset($data['data']['nome'])) {
            // return $data;
			$data['data']['val'] = url_title($data['data']['nome'], '-', TRUE);
        }
        return $data;
    }


}
