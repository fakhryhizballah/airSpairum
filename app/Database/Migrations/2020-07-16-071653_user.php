<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'nama_depan'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'nama_belakang'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'email'       => [
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
			'debit'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => TRUE,
			],
			'kredit'       => [
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

		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('user');
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
