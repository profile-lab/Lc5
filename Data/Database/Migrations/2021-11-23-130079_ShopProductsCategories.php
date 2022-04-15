<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopProductsCategories extends Migration
{
	private $db_table = 'shop_products_categories';
	public function up()
	{
		$this->forge->renameTable('shop_prod_cat', $this->db_table);

	}

	public function down()
	{
        $this->forge->renameTable( $this->db_table, 'shop_prod_cat');

	}
}
