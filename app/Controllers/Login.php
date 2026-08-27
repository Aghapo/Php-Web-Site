<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;

class Login extends BaseController
{
    /**
     * Giriş ekranını gösterir.
     */
    public function index()
    {
        // Eğer zaten giriş yapılmışsa doğrudan ana sayfaya yönlendir
        if (session()->get('giris_yapildi')) {
            return redirect()->to('/');
        }
        return view('login_view');
    }

    /**
     * Formdan gelen giriş bilgilerini güvenle doğrular.
     */
    public function kontrol()
    {
        $kullanici = trim((string) $this->request->getPost('kullanici_adi'));
        $sifre     = (string) $this->request->getPost('sifre');

        if (empty($kullanici) || empty($sifre)) {
            session()->setFlashdata('hata', 'Lütfen tüm alanları doldurunuz.');
            return redirect()->back()->withInput();
        }

        // 1. Yönetici (AdminModel) kontrolü
        $adminModel = new AdminModel();
        $admin = $adminModel->where('kullanici_adi', $kullanici)->first();

        if ($admin && password_verify($sifre, $admin['sifre'])) {
            session()->regenerate(true);
            session()->set([
                'giris_yapildi' => true,
                'admin_isim'    => $admin['kullanici_adi'],
                'user_role'     => 'admin'
            ]);
            return redirect()->to('/');
        }

        // 2. Kullanıcı (UserModel) üzerinden e-posta kontrolü
        $userModel = new UserModel();
        $user = $userModel->where('email', $kullanici)->first();

        if ($user) {
            $userPassword = is_object($user) ? $user->password : $user['password'];
            $userStatus   = is_object($user) ? $user->status : $user['status'];
            $userName     = is_object($user) ? $user->getFullName() : ($user['first_name'] . ' ' . $user['sur_name']);

            if (password_verify($sifre, $userPassword)) {
                // Hesap aktiflik kontrolü
                if ($userStatus === 'PENDING') {
                    session()->setFlashdata('hata', 'Hesabınız henüz doğrulanmamış. Lütfen e-postanıza gönderilen doğrulama bağlantısına tıklayarak hesabınızı aktif ediniz.');
                    return redirect()->back()->withInput();
                }

                session()->regenerate(true);
                session()->set([
                    'giris_yapildi' => true,
                    'admin_isim'    => $userName,
                    'user_id'       => is_object($user) ? $user->id : $user['id'],
                    'user_role'     => 'user'
                ]);
                return redirect()->to('/');
            }
        }

        session()->setFlashdata('hata', 'Girdiğiniz kullanıcı bilgileri veya şifre hatalı!');
        return redirect()->back()->withInput();
    }

    /**
     * Çıkış yapıp oturumu sonlandırır.
     */
    public function cikis()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
