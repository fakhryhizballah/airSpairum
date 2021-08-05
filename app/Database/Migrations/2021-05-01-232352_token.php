<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Token extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id_user'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'token'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'status'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],
			'updated_at'       => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],

			// 'blog_description' => [
			// 	'type'           => 'TEXT',
			// 	'null'           => TRUE,
			// ],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('token');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
