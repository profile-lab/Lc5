<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class SpeseSpedizione extends Migration
{
	private $db_table = 'shop_spese_spedizione';
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
			'public' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' 			=> true,
				'default' 		=> 0,
			],
			'is_default' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' 			=> true,
				'default' 		=> 0,
			],
			'peso_max' => [
				'type' => 'DECIMAL',
				'constraint' => '10,2',
				'default' => NULL
			],
			'prezzo_imponibile' => [
				'type' => 'DECIMAL',
				'constraint' => '10,2',
				'default' => NULL
			],
			'prezzo_aliquota' => [
				'type' => 'int',
				'constraint' => '2',
				'null' => true,
				'default' => 22
			],
			'post_type' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'null' 			=> true,
			],
			'nazione' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'is_free' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' 			=> true,
				'default' 		=> 0,
			],
			'default_nazione' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' 			=> true,
				'default' 		=> 0,
			],
			'nome' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '200',
				'null' 			=> true,
			],
			'consegna' => [
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
			'testo_breve' => [
				'type'       	=> 'TEXT',
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
			
			'extra_field' => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '255',
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
