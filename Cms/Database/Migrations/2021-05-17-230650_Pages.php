<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pages extends Migration
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
				'null' 			=> true,
				'default' 		=> 1,
			],
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
			'parent' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' 			=> false,
				'default'       => 0,
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
			'is_home' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' 			=> true,
				'default' 		=> 0,
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
			'guid' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'titolo' => [
				'type'       	=> 'VARCHAR',
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
			'seo_title' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'seo_description' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
				'null' 			=> true,
			],
			'seo_keyword' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '150',
				'null' 			=> true,
			],
			'is_posts_archive' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
				'null' 			=> true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('pages');
	}

	public function down()
	{
		$this->forge->dropTable('pages');
	}
}
