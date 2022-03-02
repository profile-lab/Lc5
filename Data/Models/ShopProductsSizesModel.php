<?php

namespace Lc5\Data\Models;
class ShopProductsSizesModel extends MasterModel
{
	protected $table                = 'shop_products_sizes';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\ShopProductsSize';
	protected $allowedFields        = [
		'id_app',
        'lang',
        'parent',
        'post_type',
        'ordine',
        'public',
        'nome',
        'val',
		
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

		return $item;
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
        if (!isset($data['data']['nome'])) {
			return $data;
        }
		// if (isset($data['data']['val']) && trim($data['data']['val']) ) {
		// 	$data['data']['val'] = url_title(trim($data['data']['val']), '-', TRUE);
		// }else{
		// 	$data['data']['val'] = url_title($data['data']['nome'], '-', TRUE);
		// }
        return $data;
    }
}
