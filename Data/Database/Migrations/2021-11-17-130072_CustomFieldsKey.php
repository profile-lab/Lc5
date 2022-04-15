<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomFieldsKey extends Migration
{
	private $db_table = 'custom_fields_keys';
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
        'nome' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '150',
            'null' 			=> true,
        ],
        'val' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '150',
            'null' 			=> true,
        ],
        'type' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '150',
            'null' 			=> true,
        ],
        'target' => [
            'type'       	=> 'VARCHAR',
            'constraint'	=> '150',
            'null' 			=> true,
        ],
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
