<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DersSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Matematik', 'Türkçe', 'Fen Bilimleri', 'İngilizce'] as $dersAdi) {
            $varMi = $this->db->table('dersler')
                ->where('ders_adi', $dersAdi)
                ->countAllResults() > 0;

            if (! $varMi) {
                $this->db->table('dersler')->insert(['ders_adi' => $dersAdi]);
            }
        }
    }
}
