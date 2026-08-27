<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'group_id'   => ['type' => 'INT', 'null' => true],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 155, 'null' => false],
            'sur_name'   => ['type' => 'VARCHAR', 'constraint' => 155, 'null' => false],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 155, 'null' => false, 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'verif_key'  => ['type' => 'VARCHAR', 'constraint' => 155, 'null' => true],
            'verif_code' => ['type' => 'INT', 'constraint' => 6, 'null' => true],
            'bio'        => ['type' => 'TEXT', 'null' => true],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'PENDING'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
