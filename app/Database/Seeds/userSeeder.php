<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 'USR19',
                'nama' => 'Fakhry',
                'email' => 'Fakhry@gmail.com',
                'telp' => '0895321701798',
                'password' => '$2y$10$qW2lRi3eNBSweV/SiGZR3uAQIsvXno2a5TuKEHQ5LcmC8n7KtCA4u', //fakhry123
                'profil' => 'user.png',
                'debit' => 2000,
                'kredit' => 40,
                'created_at' => '2020-07-16 09:21:28',
                'updated_at' => '2020-07-16 09:21:28'
            ],
            [
                'id_user' => 'neco',
                'nama' => 'Naufal',
                'email' => 'naufal@gmail.com',
                'telp' => '089918106',
                'password' => '$2y$10$JjwdFcI7vUIS2UH9GNU1yORvtIGBCwv68wqF45sp9IKWI3Q1.2Eo6', //naufal234
                'profil' => 'user.png',
                'debit' => 2000,
                'kredit' => 40,
                'created_at' => '2020-07-16 09:33:48',
                'updated_at' => '2020-07-16 09:33:48'
            ],
        ];

        $this->db->table('user')->insertBatch($data);
    }
}
