<?php

namespace Lc5\Data\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Language extends Seeder
{
	public function run()
	{
		if (!$id_app = session()->get('new_app_created_id')) { 
			$id_app = 1;
		}
		$db_table = 'languages';
		$has_dati_query = $this->db->table($db_table)->where('id_app', $id_app)->select('id')->get(1, 0);
		if (!$has_dati_query->getFirstRow()) {
			$__t_lang = (getenv('app.defaultLocale')) ? getenv('app.defaultLocale') : 'it';
			if($__t_lang != 'it'){
				$data = [
					'nome' => $__t_lang,
					'val'    => $__t_lang,
					'id_app'    => $id_app,
					'is_default' => 1
				];
			}else{
				$data = [
					'nome' => 'Italiano',
					'val'    => 'it',
					'id_app'    => $id_app,
					'is_default' => 1
				];
			}
			$this->db->table($db_table)->insert($data);
		}
	}
}
