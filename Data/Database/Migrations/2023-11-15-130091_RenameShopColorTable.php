<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameShopColorTable extends Migration
{

    public function up()
    {

        $dbInst = db_connect();
        if ($dbInst->tableExists('shop_products_colors')) {
            $this->forge->renameTable('shop_products_colors', 'shop_products_variation' );
        }
    }

    public function down()
    {
    }
}
