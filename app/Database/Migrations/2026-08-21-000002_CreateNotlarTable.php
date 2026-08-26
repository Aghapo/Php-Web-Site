<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotlarTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'ogrenci_id'  => ['type' => 'INT', 'unsigned' => true],
            'ders_id'     => ['type' => 'INT', 'unsigned' => true],
            'sinav_turu'  => ['type' => 'VARCHAR', 'constraint' => 30],
            'puan'        => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'sinav_tarihi'=> ['type' => 'DATE'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('ogrenci_id');
        $this->forge->addKey('ders_id');
        $this->forge->addForeignKey('ogrenci_id', 'ogrenciler', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ders_id', 'dersler', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('notlar');
    }

    public function down(): void
    {
        $this->forge->dropTable('notlar', true);
    }
}
