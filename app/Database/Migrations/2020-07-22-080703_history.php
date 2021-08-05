<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class History extends Migration
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
			'id_master'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'Id_slave' => [
				'type'           => 'TEXT',
				'constraint'     => '100',
			],
			'Lokasi' => [
				'type'           => 'TEXT',
				'constraint'     => '100',
				'null'           => true,
			],
			'status' => [
				'type'           => 'TEXT',
				'constraint'     => '100',
				'null'           => true,
			],
			'isi' => [
				'type'           => 'TEXT',
				'constraint'     => '100',
				'null'           => true,
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
		$this->forge->createTable('history');
	}

	public function down()
	{
		$this->forge->dropTable('history');
	}
}
