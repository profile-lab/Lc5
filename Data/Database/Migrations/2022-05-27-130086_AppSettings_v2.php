<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppSettings_v2 extends Migration
{
	private $db_table = 'lcapps_settings';
	protected $__fields = [
        'maps' => [
            'name' => 'maps',
            'type' => 'TEXT',
        ],
	];
	public function up()
	{
        $this->forge->modifyColumn($this->db_table, $this->__fields);
    }
    
	public function down()
	{
        // foreach($this->__fields as $key => $val){
        //     $this->forge->dropColumn($this->db_table, $key);
        // }
	}
}
