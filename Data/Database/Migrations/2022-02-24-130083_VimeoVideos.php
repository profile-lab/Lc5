<?php

namespace Lc5\Data\Database\Migrations;

use CodeIgniter\Database\Migration;

class VimeoVideos extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'created_at TIMESTAMP NULL DEFAULT current_timestamp()',
			'`updated_at` TIMESTAMP NULL DEFAULT NULL',
			'`deleted_at` TIMESTAMP NULL DEFAULT NULL',
			// 
            'id_app' => [
                'type'			=> 'INT',
                'constraint'	=> 11,
                'null' 			=> true,
            ],
            'lang' => [
                'type'       	=> 'VARCHAR',
                'constraint'	=> '25',
                'null' 			=> true,
            ],
			'status' => [
				'type'			=> 'tinyint',
				'constraint'	=> '1',
				'null' => true,
				'default' 		=> 0,
			],
			'vimeo_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'vimeo_path' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'video_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'guid' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'titolo' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'thumb_path' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'cover_path' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'vimeo_video_status' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'vimeo_upload_form_action' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'vimeo_upload_form_code' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'vimeo_size' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('vimeo_videos');
	}

	public function down()
	{
		$this->forge->dropTable('vimeo_videos');
	}
}
