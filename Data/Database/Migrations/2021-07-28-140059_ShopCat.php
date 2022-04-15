<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopCat extends Migration
{
	private $db_table = 'shop_prod_cat';
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
			'parent' => [
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
			'nome' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '50',
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
			'testo' => [
				'type'       	=> 'TEXT',
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
			'extra_field' => [
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
		$this->forge->createTable($this->db_table);
	}

	public function down()
	{
		$this->forge->dropTable($this->db_table);
	}
}
