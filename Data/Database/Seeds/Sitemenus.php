<?php

namespace Lc5\Data\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Sitemenus extends Seeder
{
	public function run()
	{
		if (!$id_app = session()->get('new_app_created_id')) { 
			$id_app = 1;
		}
        $db_table = 'sitemenus';

        $has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->select('id')->get(1, 0);
        if (!$has_dati_query->getFirstRow()) {
            $base_menu_structure = [];
             // 
            if (!$__t_lang = session()->get('curr_lc_lang')) {
                $__t_lang = (getenv('app.defaultLocale')) ? getenv('app.defaultLocale') : 'it';
            }
            // 


            $data = [
				'id_app' => $id_app,
                'lang' => $__t_lang,
                'nome' => 'Main Menu',
                // 'json_data' => json_encode((object) ['fields' => $base_menu_structure]),
                'json_data' => '[]',


            ];
            $this->db->table($db_table)->insert($data);
        }
	}
}
