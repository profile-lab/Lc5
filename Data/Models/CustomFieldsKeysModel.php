<?php

namespace Lc5\Data\Models;
class CustomFieldsKeysModel extends MasterModel
{
	protected $table                = 'custom_fields_keys';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\CustomFieldsKey';
	protected $allowedFields        = [
		'id',
		'id_app',
		'nome',
        'val',
        'type',
        'target',
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
        if (isset($data['data']['val'])) {			
			$data['data']['val'] = str_replace(['-'], '_', url_title($data['data']['val'], '_', TRUE));
        }        
        return $data;
    }

}
