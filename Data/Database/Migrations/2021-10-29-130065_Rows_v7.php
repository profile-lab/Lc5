<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rows_v7 extends Migration
{
	private $db_table = 'rows';
	protected $__fields = [
		'formato_media' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '100',
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
