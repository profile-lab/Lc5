<?php

namespace Lc5\Cms\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Rowsstyle extends Seeder
{
	public function run()
	{
		if (!$id_app = session()->get('new_app_created_id')) { 
			$id_app = 1;
		}
		$db_table = 'rowsstyles';
		$data = [
			'nome' => 'Paragrafo Standard',
			'val'    => 'html',
			'type'    => 'simple',
			'id_app'    => $id_app,
			'ordine'    => 10,
		];
		$has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->select('id')->get(1, 0);
		if(!$has_dati_query->getFirstRow()){
			$this->db->table($db_table)->insert($data);
		}
	}
}
