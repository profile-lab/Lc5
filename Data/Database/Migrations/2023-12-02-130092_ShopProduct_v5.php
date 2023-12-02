<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopProduct_v5 extends Migration
{
    private $db_table = 'shop_products';
    protected $__fields = [
        

        'peso_prodotto' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'default' => NULL
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
