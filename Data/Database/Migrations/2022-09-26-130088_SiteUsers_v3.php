<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class SiteUsers_v3 extends Migration
{
    private $db_table = 'site_users';
    protected $__fields = [
        'activation_token' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        '`activated_at` TIMESTAMP NULL DEFAULT NULL',

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
