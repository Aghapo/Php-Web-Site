<?php

namespace App\Database\Seeds\Demo;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('tr_TR');
        helper('text');
        $userModel = new UserModel();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'group_id'   => null,
                'first_name' => $faker->firstName(),
                'sur_name'   => $faker->lastName(),
                'email'      => $faker->email(),
                'password'   => '12345',
                'verif_key'  => random_string('alpha', 8),
                'verif_code' => random_int(100000, 999999),
                'bio'        => 'Biografinizi Yazabilirsiniz.',
                'status'     => USER_ACTIVE
            ];

            $userModel->insert($data);
        }
    }
}