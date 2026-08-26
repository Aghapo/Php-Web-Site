<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOgrenciTakipTables extends Migration
{
    public function up(): void
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'kullanici_adi' => ['type' => 'VARCHAR', 'constraint' => 100],
            'sifre'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('kullanici_adi');
        $this->forge->createTable('yoneticiler', true); // <-- true: tablo varsa atla

        $this->forge->addField('id');
        $this->forge->addField([
            'ad'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'soyad'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'foto'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('deleted_at');
        $this->forge->createTable('ogrenciler', true); // <-- true: tablo varsa atla

        $this->forge->addField('id');
        $this->forge->addField([
            'ders_adi'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('ders_adi');
        $this->forge->createTable('dersler', true); // <-- true: tablo varsa atla

        $this->forge->addField([
            'ogrenci_id' => ['type' => 'INT', 'unsigned' => true],
            'ders_id'    => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey(['ogrenci_id', 'ders_id'], true);
        $this->forge->addKey('ders_id');
        $this->forge->addForeignKey('ogrenci_id', 'ogrenciler', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ders_id', 'dersler', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('ogrenci_dersler', true); // <-- true: tablo varsa atla
    }

    public function down(): void
    {
        $this->forge->dropTable('ogrenci_dersler', true);
        $this->forge->dropTable('dersler', true);
        $this->forge->dropTable('ogrenciler', true);
        $this->forge->dropTable('yoneticiler', true);
    }
}