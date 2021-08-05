<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stasiun extends Migration
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
			'id_mesin'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'lokasi'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'lat'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '200',
			],
			'lng'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '200',
			],
			'status'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '225',
			],
			'isi'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '50',
			],
			'indikator'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '50',
			],
			'ket'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '220',
			],
			'link'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '220',
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
		$this->forge->createTable('mesin');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('mesin');
	}
}
