<?php
namespace App\Controllers;

class Dersler extends BaseController
{
    public function index()
    {
        $model = new \App\Models\DersModel();
        // Tüm dersleri alfabetik sıraya göre getir
        $data['dersler'] = $model->orderBy('ders_adi', 'ASC')->findAll();
        
        return view('dersler_view', $data);
    }

    public function kaydet()
    {
        $model = new \App\Models\DersModel();
        $dersAdi = trim((string) $this->request->getPost('ders_adi'));

        // Boş veya 2 harften kısa ders eklenmesini engelle
        $kurallar = ['ders_adi' => 'required|min_length[2]|max_length[100]'];

        if (! $this->validateData(['ders_adi' => $dersAdi], $kurallar)) {
            return redirect()->back()->with('hata', 'Ders adı en az 2 karakter olmalıdır.');
        }

        if ($model->where('ders_adi', $dersAdi)->first() !== null) {
            return redirect()->back()->withInput()->with('hata', 'Bu ders zaten kayıtlı.');
        }

        $model->insert(['ders_adi' => $dersAdi]);

        return redirect()->to('/dersler')->with('basari', 'Ders başarıyla eklendi!');
    }

    public function sil($id)
    {
        $model = new \App\Models\DersModel();

        if ($model->find($id) === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();
        $kayitSayisi = $db
            ->table('ogrenci_dersler')
            ->where('ders_id', $id)
            ->countAllResults();

        $notSayisi = $db->tableExists('notlar')
            ? $db->table('notlar')->where('ders_id', $id)->countAllResults()
            : 0;

        if ($kayitSayisi > 0 || $notSayisi > 0) {
            return redirect()->to('/dersler')->with(
                'hata',
                'Bu ders öğrencilere atanmış olduğu için silinemez.'
            );
        }

        $model->delete($id);
        
        return redirect()->to('/dersler')->with('basari', 'Ders silindi!');
    }
}
