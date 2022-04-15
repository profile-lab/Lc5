<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class SiteUsers extends Migration
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
			'status' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' => true,
				'default' 		=> 0,
			],
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null' => true,
			],
			'password' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'token' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'name' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'surname' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'null' => true,
			],
			'id_app' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' => true,
			],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('site_users');
	}

	public function down()
	{
		$this->forge->dropTable('site_users');
	}
}
