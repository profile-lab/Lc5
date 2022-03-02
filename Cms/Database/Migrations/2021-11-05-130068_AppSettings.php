<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppSettings extends Migration
{
	private $db_table = 'lcapps_settings';
	protected $__fields = [
		'id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
        '`updated_at` TIMESTAMP NULL DEFAULT NULL',
        '`deleted_at` TIMESTAMP NULL DEFAULT NULL',
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
        'youtube' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '200',
            'null' 			=> true,
        ],
        'linkedin' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '200',
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
        'entity_free_values' => [
            'type'       	=> 'TEXT',
			'null' 			=> true,
        ]
	];
	public function up()
	{
        $this->forge->addField($this->__fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable($this->db_table);
	}

	public function down()
	{
        $this->forge->dropTable($this->db_table);
	}
}
