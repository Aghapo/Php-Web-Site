<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        helper('text');
        $userModel = new UserModel();

        $data = [
            'group_id'   => null,
            'first_name' => 'Ali Veli',
            'sur_name'   => 'Akın',
            'email'      => 'admin@admin.com',
            'password'   => '12345',
            'verif_key'  => random_string('alpha', 8),
            'verif_code' => random_int(100000, 999999),
            'bio'        => "Biografinizi Yazabilirsiniz.",
            'status'     => USER_ACTIVE
        ];

        // UserModel üzerinden kaydedildiğinde created_at ve updated_at otomatik dolar
        $userModel->insert($data);
    }
}
