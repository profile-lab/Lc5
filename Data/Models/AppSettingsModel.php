<?php

namespace Lc5\Data\Models;
class AppSettingsModel extends MasterModel
{
	protected $table                = 'lcapps_settings';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\AppSetting';
	protected $allowedFields        = [
		'id',
        'id_app',
		'lang',
		'email', 
		'phone', 
		'address', 
		'piva', 
		'copy', 
		'app_description', 
		'facebook', 
		'instagram', 
		'twitter', 
		'maps', 
		'youtube', 
		'linkedin', 
		'shop', 
		'seo_title', 
		'app_claim',
        'entity_free_values',
	];

	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function beforeInsert(array $data)
	{
        // $data['data']['apikey'] = bin2hex(random_bytes(4)).'-' . bin2hex(random_bytes(10)).'-'.bin2hex(random_bytes(4)). '-' .bin2hex(random_bytes(4));
        return $data;
    }

}
