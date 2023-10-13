<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Postscategories_v2 extends Migration
{
    private $db_table = 'postscategories';
    protected $__fields = [
        'status' => [
            'type'			=> 'tinyint',
            'constraint'	=> '1',
            'null' 			=> true,
            'default' 		=> 1,
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
