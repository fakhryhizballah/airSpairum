<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Driver extends Migration
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
			'id_driver'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'email'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'cv'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'telp'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'password'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'profil'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => TRUE,
			],
			'Trip'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => TRUE,
			],
			'liter'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => TRUE,
			],
			'poin'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => TRUE,
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
		$this->forge->createTable('driver');
	}

	public function down()
	{
		$this->forge->dropTable('driver');
	}
}
