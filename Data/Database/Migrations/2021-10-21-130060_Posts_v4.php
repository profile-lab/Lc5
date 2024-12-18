<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts_v4 extends Migration
{
	private $db_table = 'posts';
	protected $__fields = [
        '`data_evento` TIMESTAMP NULL DEFAULT NULL',
        // 'has_archive' => [
        //     'type'			=> 'tinyint',
        //     'constraint'	=> '1',
        //     'null' 			=> true,
        //     'default' 		=> 1,
        // ],
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
