<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Language extends Migration
{
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
			'nome' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
				'null' 			=> true,
			],
			'val' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
				'null' 			=> true,
			],
			'is_default' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' 			=> true,
				'default' 		=> 0,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('languages');
	}

	public function down()
	{
		$this->forge->dropTable('languages');
	}
}
