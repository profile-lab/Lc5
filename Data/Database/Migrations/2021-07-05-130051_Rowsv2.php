<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsv2 extends Migration
{
	private $db_table = 'rows';
	protected $__fields = [
		'sottotitolo' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '255',
            'null' 			=> true,
            'after'         => 'titolo',
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
