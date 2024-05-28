<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts_v7 extends Migration
{
    private $db_table = 'posts';
    protected $__fields = [
        'version' => [
            'type' => 'INT',
            'constraint' => '11',
            'null' => true,
            'default' => 1
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
