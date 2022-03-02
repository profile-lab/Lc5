<?php

namespace Lc5\Data\Models;
class AdminsModel extends MasterModel
{
	protected $table                = 'admins';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Admin';
	protected $allowedFields        = [
		'id', // int(11) unsigned NOT NULL AUTO_INCREMENT,
		'status', // tinyint(1) DEFAULT '0',
		'email', // varchar(150) DEFAULT NULL,
		'password', // varchar(255) DEFAULT NULL,
		'token', // varchar(255) DEFAULT NULL,
		'name', // varchar(100) DEFAULT NULL,
		'surname', // varchar(100) DEFAULT NULL,
		'id_app', // int(11) DEFAULT NULL,
	];

	
	protected $beforeInsert         = ['beforeInsert'];
	// protected $afterInsert          = [];
	protected $beforeUpdate         = ['beforeUpdate'];
	// protected $afterUpdate          = [];
	// protected $beforeFind           = ['beforeFind'];
	// protected $afterFind            = ['afterFind'];
	// protected $beforeDelete         = [];
	// protected $afterDelete          = [];

	protected function beforeUpdate(array $data)
	{
		$data = $this->passwordHash($data);
		return $data;
	}
	protected function beforeInsert(array $data)
	{
		$data = $this->passwordHash($data);
		return $data;
	}

	protected function passwordHash(array $data)
	{
		// dd($data);
		if (isset($data['data']['password'])) {
			$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
		}

		return $data;
	}
}
