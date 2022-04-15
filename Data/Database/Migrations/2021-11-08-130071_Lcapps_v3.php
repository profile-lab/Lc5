<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lcapps_v3 extends Migration
{
	private $db_table = 'lcapps';
	protected $__fields = [
		'labels_json_object' => [
            'type'       	=> 'TEXT',
			'null' 			=> true,
        ]
	];
	public function up()
	{
        $this->forge->addColumn($this->db_table, $this->__fields);
    }
    
	public function down()
	{
        foreach($this->__fields as $key => $val){
            $this->forge->dropColumn($this->db_table, $key);
        }
	}
}
