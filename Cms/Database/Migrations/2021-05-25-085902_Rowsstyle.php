<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rowsstyle extends Migration
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
			'type' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
				'null' 			=> true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('rowsstyles');
	}

	public function down()
	{
		$this->forge->dropTable('rowsstyles');
	}
}
