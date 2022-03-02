<?php

namespace Lc5\Cms\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LcappSettings extends Seeder
{
	public function run()
	{
		if (!$id_app = session()->get('new_app_created_id')) { 
			if (!$id_app = session()->get('curr_lc_app')) {
                $id_app = 1;
            }
		}
        // 
        if (!$lang = session()->get('curr_lc_lang')) {
			$lang = 'it';
		}
        // 
        $db_table = 'lcapps_settings';
        // 
        $has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->where('lang', $lang)->select('id')->get(1, 0);
        if (!$has_dati_query->getFirstRow()) {
            $base_menu_structure = [];
            $data = [
				'id_app' => $id_app,
                'lang' => $lang,
                'entity_free_values' => '[]',
            ];
            $this->db->table($db_table)->insert($data);
        }
	}
}
