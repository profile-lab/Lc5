<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lcapps extends Migration
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
			
			'nome' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
				'null' 			=> true,
			],
			'apikey' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'domain' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'null' 			=> true,
			],
			'email' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '150',
				'null' 			=> true,
			],
			'phone' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '150',
				'null' 			=> true,
			],
			'address' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'piva' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '150',
				'null' 			=> true,
			],
			'copy' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'app_description' => [
				'type'       	=> 'text',
				'null' 			=> true,
			],
			'facebook' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'instagram' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'twitter' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'maps' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '250',
				'null' 			=> true,
			],
			'shop' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '250',
				'null' 			=> true,
			],
			'seo_title' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'app_claim' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('lcapps');
	}

	public function down()
	{
		$this->forge->dropTable('lcapps');
	}
}
