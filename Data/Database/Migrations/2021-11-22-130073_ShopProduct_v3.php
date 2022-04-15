<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopProduct_v3 extends Migration
{
        private $db_table = 'shop_products';

        protected $__fields = [
                'parent' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'null' => false,
                        'default' => 0,
                ],
                'um' => [
                        'type' => 'VARCHAR',
                        'constraint' => '20',
                        'null' => false,
                        'default' => 'PZ'
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
