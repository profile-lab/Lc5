<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopProduct_v4 extends Migration
{
    private $db_table = 'shop_products';
    protected $__fields = [
        'in_promo' => [
            'type'			=> 'tinyint',
            'constraint'	=> '1',
            'null' 			=> true,
            'default' 		=> 0,
        ],

        'promo_price' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'default' => NULL
        ],
        'discount_perc' => [
            'type' => 'INT',
            'constraint' => 4,
            'null' => false,
            'default' => 0
        ],
        'promo_mess' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],

        'scheda_tecnica' => [
            'type' => 'TEXT',
            'null' => true,
        ],
        'colore' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        'misura' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        'modello' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        'stile' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],

        'barcode' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        'sku' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
        ],
        'fornitore' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true
        ],
        'gruppo_merceologico' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true
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
