<?php

namespace App\Controllers;

use App\Models\NotModel;
use App\Models\OgrenciModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Notlar extends BaseController
{
    public function index(int $ogrenciId)
    {
        $ogrenci = $this->ogrenciyiBul($ogrenciId);
        $db = \Config\Database::connect();

        $data = [
            'ogrenci' => $ogrenci,
            'dersler' => $db->table('ogrenci_dersler as od')
                ->select('d.id, d.ders_adi')
                ->join('dersler as d', 'd.id = od.ders_id')
                ->where('od.ogrenci_id', $ogrenciId)
                ->orderBy('d.ders_adi', 'ASC')
                ->get()
                ->getResultArray(),
            'notlar' => $db->table('notlar as n')
                ->select('n.id, n.sinav_turu, n.puan, n.sinav_tarihi, d.ders_adi')
                ->join('dersler as d', 'd.id = n.ders_id')
                ->where('n.ogrenci_id', $ogrenciId)
                ->orderBy('n.sinav_tarihi', 'DESC')
                ->orderBy('n.id', 'DESC')
                ->get()
                ->getResultArray(),
            'dersOrtalamalari' => $db->table('notlar as n')
                ->select('d.ders_adi, AVG(n.puan) as ortalama', false)
                ->join('dersler as d', 'd.id = n.ders_id')
                ->where('n.ogrenci_id', $ogrenciId)
                ->groupBy('d.id, d.ders_adi')
                ->orderBy('d.ders_adi', 'ASC')
                ->get()
                ->getResultArray(),
        ];

        return view('notlar_view', $data);
    }

    public function kaydet(int $ogrenciId)
    {
        $this->ogrenciyiBul($ogrenciId);

        $kurallar = [
            'ders_id'      => 'required|is_natural_no_zero',
            'sinav_turu'   => 'required|in_list[vize,final,kisa_sinav,odev]',
            'puan'         => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
            'sinav_tarihi' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($kurallar)) {
            return redirect()->back()->withInput()->with('hatalar', $this->validator->getErrors());
        }

        $dersId = (int) $this->request->getPost('ders_id');
        if (! $this->ogrenciDerseKayitliMi($ogrenciId, $dersId)) {
            return redirect()->back()->withInput()->with('hata', 'Sadece öğrencinin aldığı derslere not girebilirsin.');
        }

        $model = new NotModel();
        $model->insert([
            'ogrenci_id'   => $ogrenciId,
            'ders_id'      => $dersId,
            'sinav_turu'   => $this->request->getPost('sinav_turu'),
            'puan'         => $this->request->getPost('puan'),
            'sinav_tarihi' => $this->request->getPost('sinav_tarihi'),
        ]);

        return redirect()->to('/ogrenci/' . $ogrenciId . '/notlar')->with('basari', 'Not başarıyla eklendi.');
    }

    public function sil(int $notId)
    {
        $model = new NotModel();
        $not = $model->find($notId);

        if ($not === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $model->delete($notId);

        return redirect()->to('/ogrenci/' . $not['ogrenci_id'] . '/notlar')->with('basari', 'Not silindi.');
    }

    /** @return array<string, mixed> */
    private function ogrenciyiBul(int $ogrenciId): array
    {
        $ogrenci = (new OgrenciModel())->find($ogrenciId);

        if ($ogrenci === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $ogrenci;
    }

    private function ogrenciDerseKayitliMi(int $ogrenciId, int $dersId): bool
    {
        return \Config\Database::connect()
            ->table('ogrenci_dersler')
            ->where('ogrenci_id', $ogrenciId)
            ->where('ders_id', $dersId)
            ->countAllResults() === 1;
    }
}
