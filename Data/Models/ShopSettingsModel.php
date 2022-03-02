<?php

namespace Lc5\Data\Models;

use CodeIgniter\Model;

class ShopSettingsModel extends Model
{   
    protected $table                = 'shop_settings';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes 		= true;
    protected $createdField  		= 'created_at';
    protected $updatedField  		= 'updated_at';
    protected $deletedField  		= 'deleted_at';
	
	protected $returnType           = 'Lc5\Data\Entities\Shopsettings';
	protected $allowedFields        = [
		'id',
        'id_app',
		'email', 
		'phone', 
		'shop_home', 

        'discount_type',
		'products_has_childs', 
		'only_digitals_products', 
		
        'shipment_active', 
		'pickup_attivo', 
        
		'paypal_account', 
		'stripe_account', 
		'sumup_account',
        
		'seo_title', 
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
