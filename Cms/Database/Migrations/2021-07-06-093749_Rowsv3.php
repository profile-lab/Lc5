<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsv3 extends Migration
{
	private $db_table = 'rows';
	protected $__fields = [
		'component' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '255',
            'null' 			=> true
        ],
		'component_params' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '255',
            'null' 			=> true
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
