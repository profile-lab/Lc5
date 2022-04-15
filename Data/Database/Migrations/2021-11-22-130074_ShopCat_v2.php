<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopCat_v2 extends Migration
{
	private $db_table = 'shop_prod_cat';
	protected $__fields = [
		'parent' => [
			'type' => 'INT',
			'constraint' => 11,
			'null' => false,
			'default' => 0,
		]
	];
	public function up()
	{
		$this->forge->modifyColumn($this->db_table, $this->__fields);
	}

	public function down()
	{
		// foreach($this->__fields as $key => $val){
		//     $this->forge->dropColumn($this->db_table, $key);
		// }
	}
}
