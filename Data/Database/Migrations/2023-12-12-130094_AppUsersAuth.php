<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppUsersAuth extends Migration
{
    public function up()
    {

        // Users Table
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nickname' => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'status' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'status_message' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'id_app' => ['type' => 'INT', 'constraint' => 11, 'null' => true,],

            'role' => ['type' => 'ENUM("USER","CONTACT","CLIENT","AGENT","ADMIN")', 'default' => 'USER', 'null' => FALSE,],
            'permissions_level' => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => 1,],

            'email' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true,],
            'name' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'surname' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],

            'cf' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'piva' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'address' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true,],
            'city' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],
            'cap' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true,],
            'tel_num' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true,],

            't_e_c' => ['type' => 'tinyint', 'constraint' => '1', 'null' => FALSE, 'default' => 0,],
            'privacy' => ['type' => 'tinyint', 'constraint' => '1', 'null' => FALSE, 'default' => 0,],
            'auth_1' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_2' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_3' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_4' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],
            'auth_5' => ['type' => 'tinyint',  'constraint' => '1',  'null' => TRUE,  'default' => 0,],

            'last_active' => ['type' => 'datetime', 'null' => true],
            'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
            '`updated_at` TIMESTAMP NULL DEFAULT NULL',
            '`deleted_at` TIMESTAMP NULL DEFAULT NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        // $this->forge->addUniqueKey('id_app', 'username');
        $this->forge->createTable('app_users_data', true);

        // Users Auth Table
        //--------------------------------------------------------------------
        //--------------------------------------------------------------------


        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'type' => ['type' => 'ENUM("email_password","token","direct_email","direct_link","single_sign_on")', 'default' => 'email_password', 'null' => FALSE,],
            'single_sign_on_account' => ['type' => 'varchar', 'constraint' => 255],
            'single_sign_on_data' => ['type' => 'varchar', 'constraint' => 255],
            'active' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'id_app' => ['type' => 'INT', 'constraint' => 11, 'null' => true,],

            'username' => ['type' => 'varchar', 'constraint' => 255],
            'secret' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'activation_token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'expires' => ['type' => 'datetime', 'null' => true],
            'extra' => ['type' => 'text', 'null' => true],
            'force_reset'  => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'last_used_at' => ['type' => 'datetime', 'null' => true],
            '`activated_at` TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
            '`updated_at` TIMESTAMP NULL DEFAULT NULL',
            '`deleted_at` TIMESTAMP NULL DEFAULT NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        // $this->forge->addUniqueKey(['type', 'username']);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'app_users_data', 'id', '', 'CASCADE');
        $this->forge->createTable('app_users_auth', true);


    }

    public function down(): void
    {
        
    }
}
