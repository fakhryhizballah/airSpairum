<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Otp extends Migration
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
			'link'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => TRUE,
			],
			'status'       => [
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
		$this->forge->createTable('otp');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
