<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transfer extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'id_slave' => [
				'type'           => 'TEXT',
				'constraint'     => '100',


			],
			'vaule' => [
				'type'           => 'TEXT',
				'constraint'     => '100',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],
			'updated_at'       => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('transfer');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transfer');
	}
}
