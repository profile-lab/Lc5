<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rows_v6 extends Migration
{
	private $db_table = 'rows';
	protected $__fields = [
		'css_extra_class' => [
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
