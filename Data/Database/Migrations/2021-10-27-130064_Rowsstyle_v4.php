<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsstyle_v4 extends Migration
{
	private $db_table = 'rowsstyles';
	protected $__fields = [
		'fields_config' => [
			'type'       	=> 'TEXT',
			'null' 			=> true,
		],
		'extra_fields_config' => [
			'type'       	=> 'TEXT',
			'null' 			=> true,
		],
	];
	public function up()
	{
		$this->forge->addColumn($this->db_table, $this->__fields);
	}

	public function down()
	{
		$this->forge->dropColumn($this->db_table, $this->__fields);
	}
}
