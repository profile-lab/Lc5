<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Poststypes_v3 extends Migration
{
	private $db_table = 'poststypes';
	protected $__fields = [
		'has_paragraphs' => [
			'type'			=> 'tinyint',
            'constraint'	=> '4',
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
