<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsv4 extends Migration
{
	private $db_table = 'rows';
	protected $__fields = [
		'video_url' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '255',
            'null' 			=> true
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
