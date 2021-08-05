<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
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
			'id_user'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'order_id'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'harga'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'bank'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'va_code'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'Biller_Code'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'Bill_Key'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'Payment_Code'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'Product_Code'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'Merchant_Code'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'User_Id'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'           => TRUE,
			],
			'status'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
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
		$this->forge->addKey('id', true);
		$this->forge->createTable('transaksi');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
