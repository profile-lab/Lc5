<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts_v2 extends Migration
{
	private $db_table = 'posts';
	protected $__fields = [
		'entity_free_values' => [
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
