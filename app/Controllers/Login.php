<?php
namespace App\Controllers;
use App\Models\AdminModel;

class Login extends BaseController
{
    // Giriş ekranını gösterir
    public function index()
    {
        // Eğer zaten giriş yapılmışsa doğrudan ana sayfaya at
        if (session()->get('giris_yapildi')) {
            return redirect()->to('/');
        }
        // return view('login_view');//Burayı açınca admin sistemi geliyor. //Admin sistemi için açmak gerekiyor.
    }

    // Formdan gelen bilgileri kontrol eder
    public function kontrol()
    {
        $model = new AdminModel();
        
        $kullanici = $this->request->getPost('kullanici_adi');
        $sifre     = $this->request->getPost('sifre');

        // 1. Sadece kullanıcı adına göre yöneticinin verilerini getir
        $admin = $model->where('kullanici_adi', $kullanici)->first();

        // 2. Admin varsa VE girilen şifre veritabanındaki şifrelenmiş kodla eşleşiyorsa:
        if ($admin && password_verify($sifre, $admin['sifre'])) {
            // Başarılı girişte oturum kimliğini yenilemek session fixation
            // saldırılarını engeller.
            session()->regenerate(true);

            session()->set([
                'giris_yapildi' => true,
                'admin_isim'    => $admin['kullanici_adi']
            ]);
            return redirect()->to('/');
            
        } else {
            return redirect()->back()->with('hata', 'Kullanıcı adı veya şifre hatalı!');
        }
    }

    // Çıkış yapıp hafızayı temizler
    public function cikis()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
