<@php

namespace App\Models;
use Lc5\Data\Models\MasterModel;

class {model_class} extends MasterModel
{

    protected $table            = '{table}';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
	protected $createdField  		= 'created_at';
	protected $updatedField  		= 'updated_at';
	protected $deletedField  		= 'deleted_at';

	protected $returnType           = 'App\Entities\{entity_class}';
	protected $allowedFields        = [
		'id',
		'nome',
	
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
        if(isset($this->is_for_frontend) && $this->is_for_frontend == true){
            if (in_array('status', $this->allowedFields)) {
                $this->where('status !=', 0);
            }
            if (in_array('public', $this->allowedFields)) {
                $this->where('public', 1);
            }
		}
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
		return $item;
	}

	protected function beforeUpdate(array $data)
	{
		return $data;
	}
	protected function beforeInsert(array $data)
	{
		$data = $this->setDataAppAndLang($data);
		return $data;
	}
}
