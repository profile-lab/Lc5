<?php

namespace Lc5\Cms\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Mediaformats extends Seeder
{
    public function run()
	{
		if (!$id_app = session()->get('new_app_created_id')) { 
			$id_app = 1;
		}
        $db_table = 'mediaformats';

        $has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->select('id')->get(1, 0);
        if (!$has_dati_query->getFirstRow()) {
            $data = [
                'nome' => 'thumbs',
                'folder' => 'thumbs',
                'rule' => 'fit',
                'w' => 500,
                'h' => 500,
                'id_app' => $id_app,
            ];
            $this->db->table($db_table)->insert($data);
            $data = [
                'nome' => 'web',
                'folder' => '',
                'rule' => '',
                'w' => 0,
                'h' => 0,
                'id_app' => $id_app,
            ];
            $this->db->table($db_table)->insert($data);
        }
    }
}
