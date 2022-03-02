<?php

namespace Lc5\Data\Models;
class LanguagesModel extends MasterModel
{
	protected $table                = 'languages';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Language';
	protected $allowedFields        = [
		'id',
		'id_app',
		'nome',
		'val',
		'is_default',
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
	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		$data = $this->beforeSave($data);
		return $data;
	}

	protected function beforeUpdate(array $data)
	{
		$data = $this->beforeSave($data);
		return $data;
	}

	private function beforeSave(array $data)
    {
		if (isset($data['data']['val'])) {			
			$data['data']['val'] = strtolower(url_title($data['data']['val'], '-', TRUE));
        }
		return $data;
	}

}
