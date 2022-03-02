<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Poststagsv2 extends Migration
{
	private $db_table = 'poststags';
	protected $__fields = [
		'post_type' => [
            'type'			=> 'INT',
            'constraint'	=> 11,
            'null' 			=> true,
        ],
        'ordine' => [
            'type'			=> 'INT',
            'constraint'	=> 11,
            'null' 			=> true,
            'default' 		=> 500,
        ],
        'public' => [
            'type'			=> 'tinyint',
            'constraint'	=> '1',
            'null' 			=> true,
            'default' 		=> 0,
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
