<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsstylev3 extends Migration
{
	private $db_table = 'rowsstyles';
	protected $__fields = [
		'ordine' => [
            'type'			=> 'INT',
            'constraint'	=> 11,
            'null' 			=> true,
            'default' 		=> 500,
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
