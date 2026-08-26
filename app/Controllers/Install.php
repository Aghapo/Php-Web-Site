<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class Install extends BaseController{

    public function create_Table() {
        $migrate = \Config\Services::migrations();
        $migrate ->latest();
    }

    public function createAdmin() {
        $seeder = Database::seeder();
        $seeder -> call('App\Database\Seeds\AdminSeeder');
    }

    public function createDemo() {
        $seeder = Database::seeder();
        $seeder -> call('App\Database\Seeds\Demo\UserSeeder');
    }    
}