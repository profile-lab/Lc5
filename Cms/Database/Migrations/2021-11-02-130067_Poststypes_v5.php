<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Poststypes_v5 extends Migration
{
	private $db_table = 'poststypes';
	protected $__fields = [
		'archive_root' => [
			'type'       	=> 'VARCHAR',
            'constraint'	=> '255',
            'null' 			=> true,
        ],
		'has_archive' => [
			'type'			=> 'tinyint',
			'constraint'	=> '1',
			'null' 			=> true,
			'default' 		=> 1,
		],
		'has_custom_fields' => [
			'type'			=> 'tinyint',
			'constraint'	=> '1',
            'null' 			=> true,
            'default' 		=> 0,
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
