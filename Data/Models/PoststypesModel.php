<?php

namespace Lc5\Data\Models;

class PoststypesModel extends MasterModel
{
	protected $table                = 'poststypes';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Poststype';
	protected $allowedFields        = [
		'id',
		'id_app',
		'parent',
		'nome',
		'val',
		'fields_config',
		'extra_fields_config',
		'has_paragraphs',

		'post_order',
		'post_sort',
		'post_per_page',

		'archive_root',
		'has_archive',
		'has_custom_fields',
		
	];

	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = ['beforeFind'];
	protected $afterFind            = ['afterFind'];
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
	protected function afterFind(array $data)
	{
		// $data = $this->beforeSave($data);
		if($data['singleton'] == true){
			$data['data'] = $this->extendData($data['data']);
		}else{
			foreach($data['data'] as $item){
				$item = $this->extendData($item);
			}
		}
		return $data;
	}
	private function extendData($item)
	{
		if($item){
			$item->titolo = $item->nome;
		}
		return $item;
	}
}
