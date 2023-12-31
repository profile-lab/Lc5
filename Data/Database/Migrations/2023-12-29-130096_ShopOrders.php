<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShopOrders extends Migration
{
    public function up()
    {
        // Users Table
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_app' => ['type' => 'INT', 'constraint' => 11, 'null' => true,],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'order_status' => ['type' => 'ENUM("CART","ORDER","IN_PROGRESS","SHIPPED","IN_DELIVERY","DELIVERED","DELETED","DELETED_BY_USER","DELETED_BY_ADMIN")', 'default' => 'CART', 'null' => FALSE,],
            'last_status_change' => ['type' => 'datetime', 'null' => true],

            'email' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true,],
            'tel_num' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],

            'name' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'surname' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'country' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true, 'default' => 'IT'],
            'district' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'city' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'address' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],
            'street_number' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true,],
            'cap' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true,],


            'legal_name' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'legal_secondname' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'legal_country' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true, 'default' => 'IT'],
            'legal_district' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'legal_city' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'legal_address' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],
            'legal_street_number' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true,],
            'legal_cap' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true,],
            'legal_vat' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'legal_fiscal' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],



            'note' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],
            'note_admin' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],

            'spedizione_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true,],
            'spedizione_type' => ['type' => 'ENUM("COURIER","PICKUP","AT_DELIVERY","FREE")', 'default' => 'COURIER', 'null' => FALSE,],
            'spedizione_name' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'consegna' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'consegna_note' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],
            'consegna_corriere' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'consegna_date' =>  ['type' => 'datetime', 'null' => true],
            'consegna_track_code' =>  ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],


            'payment_type' => ['type' => 'ENUM("STRIPE","CASH","CC","BANK","PAYPAL","AT_DELIVERY","FREE")', 'default' => 'CASH', 'null' => FALSE,],
            'payment_status' => ['type' => 'ENUM("PENDING","COMPLETED","ERROR","FREE")', 'default' => 'PENDING', 'null' => FALSE,],
            'payment_code' =>  ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],
            'payed_at' =>  ['type' => 'datetime', 'null' => true],
            'stripe_pi' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],


            'imponibile_total' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'promo_total' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'iva_total' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'spese_spedizione_imponibile' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'spese_spedizione' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'total' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],

            'referenze' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'referenze_totali' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'peso_totale_grammi' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],

            'qnt_scaricate' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],

            'auth_1' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_2' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_3' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_4' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_5' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],


            'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
            '`updated_at` TIMESTAMP NULL DEFAULT NULL',
            '`deleted_at` TIMESTAMP NULL DEFAULT NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('shop_orders', true);

        // Users Auth Table
        //--------------------------------------------------------------------
        //--------------------------------------------------------------------


        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_app' => ['type' => 'INT', 'constraint' => 11, 'null' => true,],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'row_key' =>  ['type' => 'varchar', 'constraint' => 50, 'null' => TRUE,],
            'reference_type' => ['type' => 'varchar', 'constraint' => 100, 'default' => 'shop_products', 'null' => FALSE,],
            'reference_id' => ['type' => 'int', 'constraint' => 11, 'null' => FALSE,],
            'reference_model_id' => ['type' => 'int', 'constraint' => 11, 'null' => FALSE,],
            'reference_name' =>  ['type' => 'varchar', 'constraint' => 150, 'null' => TRUE,],
            'reference_model_name' => ['type' => 'varchar', 'constraint' => 150, 'null' => TRUE,],
            'full_nome_prodotto' => ['type' => 'varchar', 'constraint' => 150, 'null' => TRUE,],
            'permalink' => ['type' => 'varchar', 'constraint' => 150, 'null' => TRUE,],

            'qnt' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'qnt_scaricate' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'prezzo_uni' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],
            'prezzo' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00,],

            'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
            '`updated_at` TIMESTAMP NULL DEFAULT NULL',
            '`deleted_at` TIMESTAMP NULL DEFAULT NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('shop_orders_items', true);
    }

    public function down(): void
    {
    }
}
