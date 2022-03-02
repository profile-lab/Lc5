<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rows extends Migration
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
			'lang' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '25',
				'null' 			=> true,
			],
			'modulo' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'null' 			=> true,
			],
			'parent' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' 			=> true,
			],
			'master_row' => [
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
			'type' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'null' 			=> true,
			],
			'nome' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'titolo' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'testo' => [
				'type'       	=> 'TEXT',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'main_img_id' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' 			=> true,
			],
			'alt_img_id' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' 			=> true,
			],
			'css_class' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'null' 			=> true,
			],
			'css_color' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'null' 			=> true,
			],
			'cta_url' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'cta_label' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'extra_field' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'custom_field' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'gallery' => [
				'type'       	=> 'TEXT',
				'null' 			=> true,
			],
			'json_data' => [
				'type'       	=> 'TEXT',
				'null' 			=> true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('rows');
	}

	public function down()
	{
		$this->forge->dropTable('rows');
	}
}
