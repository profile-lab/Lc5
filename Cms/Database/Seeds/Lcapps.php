<?php

namespace Lc5\Cms\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Lcapps extends Seeder
{
	public function run()
	{
		$db_table = 'lcapps';
		$has_dati_query = $this->db->table($db_table)->select('id')->get(1, 0);
		if (!$has_dati_query->getFirstRow()) {
			$data = [
				'nome' => 'LC-APP',
				'apikey' => bin2hex(random_bytes(4)).'-' . bin2hex(random_bytes(10)).'-'.bin2hex(random_bytes(4)). '-' .bin2hex(random_bytes(4))
			];
			$this->db->table($db_table)->insert($data);
		}
	}
}
