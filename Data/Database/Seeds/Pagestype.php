<?php

namespace Lc5\Data\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pagestype extends Seeder
{
	public function run()
	{
		if (!$id_app = session()->get('new_app_created_id')) { 
			$id_app = 1;
		}

		$db_table = 'pagestypes';
		$data = [
			'nome' => 'Webpage',
			'val'    => 'webpage',
			'id_app'    => $id_app
		];
		$has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->select('id')->get(1, 0);
		if(!$has_dati_query->getFirstRow()){
			$this->db->table($db_table)->insert($data);
		}

	}
}
