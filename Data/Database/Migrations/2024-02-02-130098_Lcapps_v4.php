<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lcapps_v4 extends Migration
{
    private $db_table = 'lcapps';
    protected $__fields = [
        

        'status' => [
            'type'			=> 'tinyint',
            'constraint'	=> '1',
            'null' 			=> true,
            'default' 		=> 1,
        ],
        'is_in_maintenance_mode' => [
            'type'			=> 'tinyint',
            'constraint'	=> '1',
            'null' 			=> true,
            'default' 		=> 0,
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
