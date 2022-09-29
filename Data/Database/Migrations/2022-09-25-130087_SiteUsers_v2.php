<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class SiteUsers_v2 extends Migration
{
    private $db_table = 'site_users';
    protected $__fields = [
       
        'role' => [
            'type' => 'ENUM("APP-USER","CLIENTE","AGENTE")',
            'default' => 'APP-USER',
            'null' => FALSE,
        ],
        'permissions' => [
            'type' => 'TEXT'
        ],
        'profili_attivi' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
            'default' => 0,
        ],
        '`last_login` TIMESTAMP NULL DEFAULT NULL',

        'cf' => [
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => true,
        ],
        'piva' => [
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => true,
        ],
        'address' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        'city' => [
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => true,
        ],
        'cap' => [
            'type' => 'VARCHAR',
            'constraint' => '50',
            'null' => true,
        ],
        'tel_num' => [
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => true,
        ],

        't_e_c' => [
            'type' => 'tinyint',
            'constraint' => '1',
            'null' => FALSE,
            'default' => 0,
        ],
        'autorizzo_1' => [
            'type' => 'tinyint',
            'constraint' => '1',
            'null' => TRUE,
            'default' => 0,
        ],
        'autorizzo_2' => [
            'type' => 'tinyint',
            'constraint' => '1',
            'null' => TRUE,
            'default' => 0,
        ],
        'autorizzo_3' => [
            'type' => 'tinyint',
            'constraint' => '1',
            'null' => TRUE,
            'default' => 0,
        ],
        'autorizzo_4' => [
            'type' => 'tinyint',
            'constraint' => '1',
            'null' => TRUE,
            'default' => 0,
        ],
        'autorizzo_5' => [
            'type' => 'tinyint',
            'constraint' => '1',
            'null' => TRUE,
            'default' => 0,
        ],
    ];
    public function up()
    {
        $this->forge->addColumn($this->db_table, $this->__fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->db_table, $this->__fields);
    }
}
