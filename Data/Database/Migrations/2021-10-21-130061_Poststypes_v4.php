<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Poststypes_v4 extends Migration
{
	private $db_table = 'poststypes';
	protected $__fields = [
		'post_order' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '50',
            'default'       => 'id',
            'null' 			=> true
        ],
		'post_sort' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '10',
            'default'       => 'DESC',
            'null' 			=> true
        ],
		'post_per_page' => [
            'type'           => 'INT',
            'constraint'     => 5,
            'default'       => '24',
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
