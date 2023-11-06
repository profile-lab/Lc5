<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameShopBaseTables extends Migration
{

    public function up()
    {
        $tablesnames = [
            'shop_aliquote', 'shop_products', 'shop_products_categories', 'shop_products_colors',
            'shop_products_sizes', 'shop_products_tags', 'shop_settings',
        ];
        $dbInst = db_connect();
        foreach ($tablesnames as $curr_tableName) {
            if ($dbInst->tableExists($curr_tableName)) {
                $this->forge->renameTable($curr_tableName, '_old_' . $curr_tableName);
            }
        }
    }

    public function down()
    {
    }
}
