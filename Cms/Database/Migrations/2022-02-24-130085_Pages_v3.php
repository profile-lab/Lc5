<?php

namespace Lc5\Cms\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pages_v3 extends Migration
{
	private $db_table = 'pages';
	protected $__fields = [
		'vimeo_video_id' => [
            'type' => 'VARCHAR',
            'constraint' => '50',
            'null' => true,
        ],
        'vimeo_video_url' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => true,
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
