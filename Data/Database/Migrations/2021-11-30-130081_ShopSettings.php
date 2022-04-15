<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopSettings extends Migration
{
    private $db_table = 'shop_settings';

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
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'shop_home' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'discount_type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
                'default' => 'PRICE',
            ],
            'products_has_childs' => [
                'type' => 'tinyint',
                'constraint' => '1',
                'null' => false,
                'default' => 1,
            ],
            'only_digitals_products' => [
                'type' => 'tinyint',
                'constraint' => '1',
                'null' => false,
                'default' => 0,
            ],
            'shipment_active' => [
                'type' => 'tinyint',
                'constraint' => '1',
                'null' => false,
                'default' => 1,
            ],
            'pickup_attivo' => [
                'type' => 'tinyint',
                'constraint' => '1',
                'null' => false,
                'default' => 0,
            ],
            'paypal_account' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'stripe_account' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sumup_account' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'seo_title' => [
                'type'       	=> 'VARCHAR',
                'constraint'	=> '255',
                'null' 			=> true,
            ],
            'entity_free_values' => [
                'type' => 'TEXT',
                'null' => true,
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
