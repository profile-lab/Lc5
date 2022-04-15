<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sitemenus extends Migration
{
	private $db_table = 'sitemenus';

	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
			'`updated_at` TIMESTAMP NULL DEFAULT NULL',
			'`deleted_at` TIMESTAMP NULL DEFAULT NULL',
			// 
			'id_app' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' 			=> true,
			],
			'lang' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '25',
				'null' 			=> true,
			],
			'nome' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
				'null' 			=> true,
			],
			'json_data' => [
				'type'       	=> 'TEXT',
				'null' 			=> true,
			],
			
			// 'custom_field' => [
			// 	'type'       	=> 'VARCHAR',
			// 	'constraint'	=> '255',
			// 	'null' 			=> true,
			// ],
			
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable($this->db_table);
	}

	public function down()
	{
		$this->forge->dropTable($this->db_table);
	}
}
