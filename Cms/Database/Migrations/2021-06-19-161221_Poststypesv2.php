<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Poststypesv2 extends Migration
{
	private $db_table = 'poststypes';
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
