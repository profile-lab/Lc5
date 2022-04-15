<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopAliquote extends Migration
{
	private $db_table = 'shop_aliquote';

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
                'null' => false,
                'default' => '22',
			],
			'val' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 22,
			],
            'is_default' => [
                'type' => 'tinyint',
                'constraint' => '1',
                'null' => false,
                'default' => 0,
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
