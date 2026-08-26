<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DersSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
