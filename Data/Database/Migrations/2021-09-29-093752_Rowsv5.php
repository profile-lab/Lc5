<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsv5 extends Migration
{
	private $db_table = 'rows';
	protected $__fields = [
		'free_values' => [
            'type'       	=> 'TEXT',
			'null' 			=> true,
        ]
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
