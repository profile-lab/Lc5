<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lcapps_v2 extends Migration
{
	private $db_table = 'lcapps';
	protected $__fields = [
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
	];
	public function up()
	{
        foreach($this->__fields as $key => $val){
            $this->forge->dropColumn($this->db_table, $key);
        }
    }
    
	public function down()
	{
        $this->forge->addColumn($this->db_table, $this->__fields);
	}
}
