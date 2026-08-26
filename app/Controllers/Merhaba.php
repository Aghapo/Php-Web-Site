<?php

namespace App\Controllers;

use App\Models\OgrenciModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Merhaba extends BaseController
{
        public function index()
    {
        $model = new OgrenciModel();
        $db = \Config\Database::connect();

        //İstatikleri alıyoruz.
        $data['aktif_ogrenci_sayisi'] = $model -> countAllResults();
        $data['silinmis_ogrenci_sayısı'] = $model -> onlyDeleted() -> countAllResults();
        $data['ders_sayisi'] = $db -> table('dersler') -> countAllResults();


        // ARAMA İŞLEMİ
        $arama_kelimesi = $this->request->getGet('kelime'); 
        if (!empty($arama_kelimesi)) {
        $model->groupStart()
            ->like('ad', $arama_kelimesi)
            ->orLike('soyad', $arama_kelimesi)
            ->groupEnd();
    }

        //Sayfalama
        $data['ogrenciler'] = $model->paginate(10);
        $data['pager'] = $model->pager;
        
        $data['dersler']    = $db->table('dersler')->get()->getResultArray();

        $data['sayfa_basligi'] = 'CodeIgniter + MS SQL';
        $data['arama_kelimesi'] = $arama_kelimesi;


        foreach ($data['ogrenciler'] as &$ogrenci) {
            $dersler=$db->table('ogrenci_dersler')
                        ->select('dersler.ders_adi')
                        ->join('dersler', 'dersler.id = ogrenci_dersler.ders_id')
                        ->where('ogrenci_id', $ogrenci['id'])
                        ->get()->getResultArray();
            // Bulunan derslerin sadece isimlerini alıp virgülle ayrılmış bir metne çeviriyoruz (Örn: Matematik, Fizik)
            $ogrenci['aldigi_dersler'] = implode(', ', array_column($dersler, 'ders_adi'));
        } 
        return view('merhaba_view', $data);
    }



    public function ekleSayfasi() 
    {   
        $dersModel = new \App\Models\DersModel();
        $data['dersler'] = $dersModel->findAll();   
        return view("Öğrenci_Ekle_view", $data);
    }
    


    

    public function kaydet()
    {
        if (! $this->ogrenciIstekGecerliMi()) {
            return redirect()->back()->withInput()->with('hatalar', $this->validator->getErrors());
        }

        $secilenDersler = $this->secilenDersleriAl();
        if ($secilenDersler === null || ! $this->derslerGecerliMi($secilenDersler)) {
            return redirect()->back()->withInput()->with('hatalar', [
                'dersler' => 'Seçilen derslerden biri geçersiz.',
            ]);
        }

        $dosya = $this->request->getFile('foto');
        $fotoAdi = $this->fotoyuYukle($dosya);
        $model = new OgrenciModel();
        $db = \Config\Database::connect();

        try {
            $db->transBegin();

            if (! $model->insert([
                'ad'    => trim((string) $this->request->getPost('ad')),
                'soyad' => trim((string) $this->request->getPost('soyad')),
                'foto'  => $fotoAdi,
            ])) {
                throw new \RuntimeException('Öğrenci kaydı oluşturulamadı.');
            }

            $this->dersleriKaydet((int) $model->getInsertID(), $secilenDersler);

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Öğrenci dersleri kaydedilemedi.');
            }

            $db->transCommit();
        } catch (\Throwable $exception) {
            $db->transRollback();
            $this->yuklenenFotoyuSil($fotoAdi);
            log_message('error', 'Öğrenci kaydı oluşturulamadı: {message}', ['message' => $exception->getMessage()]);

            return redirect()->back()->withInput()->with('hata', 'Kayıt sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }

        return redirect()->to('/')->with('basari', 'Öğrenci başarıyla eklendi.');
    }





    public function sil($id = null)
    {
        $model = new OgrenciModel();
        if ($model->find($id) === null) {
            return $this->ogrenciBulunamadiYaniti();
        }

        $model->delete($id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'basari'   => true,
                'mesaj'    => 'Öğrenci başarıyla silindi!',
                'csrfHash' => csrf_hash(),
            ]);
        }

        return redirect() ->to('/')-> with('basari', 'Öğrenci Başarıyla Silindi!');
    }






    public function kalici_sil($id = null)
    {
        $model = new OgrenciModel();
        $ogrenci = $model->onlyDeleted()->find($id);

        if ($ogrenci === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();
        try {
            $db->transBegin();
            $db->table('ogrenci_dersler')->where('ogrenci_id', $id)->delete();
            $model->delete($id, true);

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Öğrenci kalıcı olarak silinemedi.');
            }

            $db->transCommit();
        } catch (\Throwable $exception) {
            $db->transRollback();
            log_message('error', 'Öğrenci kalıcı olarak silinemedi: {message}', ['message' => $exception->getMessage()]);

            return redirect()->to('/ogrenci/cop_kutusu')->with('hata', 'Silme sırasında bir hata oluştu.');
        }

        $this->yuklenenFotoyuSil($ogrenci['foto']);

        return redirect()->to('/ogrenci/cop_kutusu')->with('basari', 'Öğrenci kalıcı olarak silindi!');
    }

    public function duzenle($id = null) 
    {
        $model = new OgrenciModel();
        $data['ogrenci'] = $model->find($id); 

        if ($data['ogrenci'] === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $dersModel = new \App\Models\DersModel();
        $data['dersler'] = $dersModel->findAll();

        $db = \Config\Database::connect();
        $mevcut_dersler = $db -> table('ogrenci_dersler') -> where('ogrenci_id' , $id) -> get() ->getResultArray();
        $data['secili_dersler'] = array_column($mevcut_dersler , 'ders_id');
        
        return view("ogrenci_duzenle_view" , $data);
    }

    public function guncelle($id = null)
    {
        $model = new OgrenciModel();
        $eskiOgrenci = $model->find($id);
        if ($eskiOgrenci === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (! $this->ogrenciIstekGecerliMi()) {
            return redirect()->back()->withInput()->with('hatalar', $this->validator->getErrors());
        }

        $secilenDersler = $this->secilenDersleriAl();
        if ($secilenDersler === null || ! $this->derslerGecerliMi($secilenDersler)) {
            return redirect()->back()->withInput()->with('hatalar', [
                'dersler' => 'Seçilen derslerden biri geçersiz.',
            ]);
        }

        $fotoAdi = $this->fotoyuYukle($this->request->getFile('foto'));
        $veri = [
            'ad'    => trim((string) $this->request->getPost('ad')),
            'soyad' => trim((string) $this->request->getPost('soyad')),
        ];
        if ($fotoAdi !== null) {
            $veri['foto'] = $fotoAdi;
        }

        $db = \Config\Database::connect();
        try {
            $db->transBegin();
            if (! $model->update($id, $veri)) {
                throw new \RuntimeException('Öğrenci güncellenemedi.');
            }

            $db->table('ogrenci_dersler')->where('ogrenci_id', $id)->delete();
            $this->dersleriKaydet((int) $id, $secilenDersler);

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Öğrenci dersleri güncellenemedi.');
            }

            $db->transCommit();
        } catch (\Throwable $exception) {
            $db->transRollback();
            $this->yuklenenFotoyuSil($fotoAdi);
            log_message('error', 'Öğrenci güncellenemedi: {message}', ['message' => $exception->getMessage()]);

            return redirect()->back()->withInput()->with('hata', 'Güncelleme sırasında bir hata oluştu.');
        }

        if ($fotoAdi !== null) {
            $this->yuklenenFotoyuSil($eskiOgrenci['foto']);
        }

        return redirect()->to('/')->with('basari', 'Öğrenci başarıyla güncellendi!');
    }


    public function cop_kutusu()
    {
        $model = new \App\Models\OgrenciModel();
        $data['ogrenciler'] = $model -> onlyDeleted() ->findAll();

        return view('cop_kutusu_view' , $data);
    }


    public function kurtar($id)
    {
        $model = new OgrenciModel();
        if ($model->onlyDeleted()->find($id) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $model->update($id, ['deleted_at' => null]);

        return redirect()->to('/ogrenci/cop_kutusu')->with('basari', 'Öğrenci geri yüklendi.');
    }

    public function excelAktar()
    {
        $model = new \App\Models\OgrenciModel();
        $ogrenciler = $model->findAll();
        $db = \Config\Database::connect();

        // Türkçe karakterlerin Excel'de bozulmaması için BOM ekliyoruz.
        $output = fopen('php://temp', 'r+');
        fwrite($output, "\xEF\xBB\xBF");

        // 4. Excel tablosunun en üstündeki başlıkları yazdır (Türkiye ayarları için ayırıcıyı noktalı virgül ';' yapıyoruz)
        fputcsv($output, ['ID', 'Ad', 'Soyad', 'Aldığı Dersler'], ';');

        // 5. Öğrencileri döngüye alıp alt alta satır olarak ekle
        foreach ($ogrenciler as $ogrenci) {
            
            // Öğrencinin aldığı dersleri bul
            $dersler = $db->table('ogrenci_dersler as od')
                        ->select('d.ders_adi')
                        ->join('dersler as d', 'd.id = od.ders_id')
                        ->where('od.ogrenci_id', $ogrenci['id'])
                        ->get()->getResultArray();
                        
            $ders_isimleri = implode(', ', array_column($dersler, 'ders_adi'));

            // Bilgileri dosyaya tek bir satır olarak yazdır
            fputcsv($output, [
                $ogrenci['id'],
                $this->csvDegeriniGuvenliYap($ogrenci['ad']),
                $this->csvDegeriniGuvenliYap($ogrenci['soyad']),
                $this->csvDegeriniGuvenliYap($ders_isimleri),
            ], ';');
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="ogrenci_listesi.csv"')
            ->setBody($csv);
    }

    /** @return array<string, array<string, string>> */
    private function ogrenciKurallari(): array
    {
        $kurallar = [
            'ad' => [
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'   => 'Öğrenci adı alanı boş bırakılamaz.',
                    'min_length' => 'Öğrenci adı en az 3 karakterden oluşmalıdır.',
                    'max_length' => 'Öğrenci adı en fazla 50 karakter olabilir.',
                ],
            ],
            'soyad' => [
                'rules'  => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required'   => 'Öğrenci soyadı alanı boş bırakılamaz.',
                    'min_length' => 'Öğrenci soyadı en az 2 karakterden oluşmalıdır.',
                    'max_length' => 'Öğrenci soyadı en fazla 50 karakter olabilir.',
                ],
            ],
        ];

        $dosya = $this->request->getFile('foto');
        if ($dosya !== null && $dosya->getError() !== UPLOAD_ERR_NO_FILE) {
            $kurallar['foto'] = [
                'rules'  => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|ext_in[foto,jpg,jpeg,png,webp]',
                'errors' => [
                    'uploaded' => 'Fotoğraf yüklenirken bir hata oluştu.',
                    'max_size' => 'Fotoğraf boyutu en fazla 2 MB olabilir.',
                    'is_image' => 'Lütfen geçerli bir resim dosyası yükleyin.',
                    'mime_in'  => 'Sadece JPG, JPEG, PNG ve WEBP formatları desteklenmektedir.',
                    'ext_in'   => 'Fotoğraf uzantısı JPG, JPEG, PNG veya WEBP olmalıdır.',
                ],
            ];
        }

        return $kurallar;
    }

    private function ogrenciIstekGecerliMi(): bool
    {
        return $this->validate($this->ogrenciKurallari());
    }

    /** @return list<int>|null Geçersiz bir istek için null döner. */
    private function secilenDersleriAl(): ?array
    {
        $gelenDersler = $this->request->getPost('dersler');
        if ($gelenDersler === null) {
            return [];
        }

        if (! is_array($gelenDersler)) {
            return null;
        }

        $dersler = [];
        foreach ($gelenDersler as $dersId) {
            if (! is_scalar($dersId) || ! ctype_digit((string) $dersId) || (int) $dersId < 1) {
                return null;
            }

            $dersler[] = (int) $dersId;
        }

        return array_values(array_unique($dersler));
    }

    /** @param list<int> $dersler */
    private function derslerGecerliMi(array $dersler): bool
    {
        if ($dersler === []) {
            return true;
        }

        $bulunanDersSayisi = \Config\Database::connect()
            ->table('dersler')
            ->whereIn('id', $dersler)
            ->countAllResults();

        return (int) $bulunanDersSayisi === count($dersler);
    }

    /** @param list<int> $dersler */
    private function dersleriKaydet(int $ogrenciId, array $dersler): void
    {
        $builder = \Config\Database::connect()->table('ogrenci_dersler');
        foreach ($dersler as $dersId) {
            if ($builder->insert(['ogrenci_id' => $ogrenciId, 'ders_id' => $dersId]) === false) {
                throw new \RuntimeException('Öğrenci-ders ilişkisi kaydedilemedi.');
            }
        }
    }

    private function fotoyuYukle(?\CodeIgniter\HTTP\Files\UploadedFile $dosya): ?string
    {
        if ($dosya === null || $dosya->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $dosya->isValid() || $dosya->hasMoved()) {
            throw new \RuntimeException('Fotoğraf yüklenemedi.');
        }

        $fotoAdi = $dosya->getRandomName();
        $dosya->move(FCPATH . 'uploads', $fotoAdi);

        return $fotoAdi;
    }

    private function yuklenenFotoyuSil(?string $fotoAdi): void
    {
        if ($fotoAdi === null || basename($fotoAdi) !== $fotoAdi) {
            return;
        }

        $yol = FCPATH . 'uploads/' . $fotoAdi;
        if (is_file($yol)) {
            unlink($yol);
        }
    }

    private function ogrenciBulunamadiYaniti()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setStatusCode(404)->setJSON([
                'basari'   => false,
                'mesaj'    => 'Öğrenci bulunamadı.',
                'csrfHash' => csrf_hash(),
            ]);
        }

        throw PageNotFoundException::forPageNotFound();
    }

    private function csvDegeriniGuvenliYap(string $deger): string
    {
        return preg_match('/^[=+\\-@]/', $deger) === 1 ? "'" . $deger : $deger;
    }
}
