<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppUsersData_v2 extends Migration
{
    private $db_table = 'app_users_data';
    protected $__fields = [
        
        'country' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,'default' => 'IT'],
        'district' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
        'street_number' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true,],

        


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
