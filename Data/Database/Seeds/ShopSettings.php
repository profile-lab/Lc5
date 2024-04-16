<?php

namespace Lc5\Data\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShopSettings extends Seeder
{
    public function run()
    {
        if (!$id_app = session()->get('new_app_created_id')) {
            $id_app = 1;
        }
        $db_table = 'shop_settings';
        if ($this->db->tableExists($db_table)) {
            $has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->select('id')->get(1, 0);
            if (!$has_dati_query->getFirstRow()) {
                $data = [
                    'id_app' => $id_app,
                    'shop_home' => '/shop',
                    'discount_type' => 'PRICE',
                    'products_has_childs' => 0,
                    'only_digitals_products' => 0,
                    'shipment_active' => 1,
                    'pickup_attivo' => 0,
                ];
                $this->db->table($db_table)->insert($data);
            }
        }
    }
}
