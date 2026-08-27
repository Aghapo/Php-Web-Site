<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Libraries\EmailService;
use App\Models\UserModel;

class Auth extends BaseController
{
    /**
     * E-posta Doğrulama İşlemi (GET /auth/verify/{token})
     */
    public function verify(string $token = '')
    {
        $locale = $this->request->getLocale();
        $userModel = new UserModel();

        if (empty($token)) {
            session()->setFlashdata('error', lang('Auth.verify_invalid'));
            return redirect()->to("/{$locale}/login");
        }

        // Token ile eşleşen kullanıcıyı bul
        $user = $userModel->where('verif_key', $token)->first();

        if (! $user) {
            session()->setFlashdata('error', lang('Auth.verify_invalid'));
            return redirect()->to("/{$locale}/login");
        }

        helper('text');

        // Kullanıcıyı aktif et ve anahtarı yenileyerek eski linki geçersiz kıl (NULL hatasını önler)
        $user->setStatus(defined('USER_ACTIVE') ? USER_ACTIVE : 'ACTIVE');
        $user->setVerifKey(random_string('alnum', 32));

        $userModel->save($user);

        // 2. E-posta: Hesap Doğrulandı bildirim postası gönder
        $emailService = new EmailService();
        $emailService->sendAccountVerified($user);

        session()->setFlashdata('success', lang('Auth.verify_success'));
        return redirect()->to("/{$locale}/login");
    }

    /**
     * Şifremi Unuttum Sayfası (GET /auth/forgot-password)
     */
    public function forgotPassword()
    {
        return view('pagers/forgot_password', [
            'title' => lang('Auth.forgot_password_title')
        ]);
    }

    /**
     * Şifre Sıfırlama Talebi Gönderimi (POST /auth/forgot-password)
     */
    public function sendResetLink()
    {
        $locale = $this->request->getLocale();

        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ]
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $email = (string) $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (! $user) {
            session()->setFlashdata('error', lang('Auth.user_not_found'));
            return redirect()->back()->withInput();
        }

        helper('text');
        $resetToken = random_string('alnum', 32);

        $user->setVerifKey($resetToken);
        $userModel->save($user);

        // 3. E-posta: Şifre sıfırlama bağlantısı gönder
        $emailService = new EmailService();
        $emailService->sendPasswordReset($user, $resetToken);

        session()->setFlashdata('success', lang('Auth.reset_link_sent'));
        return redirect()->back();
    }

    /**
     * Yeni Şifre Belirleme Sayfası (GET /auth/reset-password/{token})
     */
    public function resetPassword(string $token = '')
    {
        $locale = $this->request->getLocale();
        $userModel = new UserModel();

        if (empty($token) || ! $userModel->where('verif_key', $token)->first()) {
            session()->setFlashdata('error', lang('Auth.reset_token_invalid'));
            return redirect()->to("/{$locale}/auth/forgot-password");
        }

        return view('pagers/reset_password', [
            'title' => lang('Auth.reset_password_title'),
            'token' => $token
        ]);
    }

    /**
     * Yeni Şifreyi Kaydetme İşlemi (POST /auth/reset-password/{token})
     */
    public function updatePassword(string $token = '')
    {
        $locale = $this->request->getLocale();
        $userModel = new UserModel();

        $user = $userModel->where('verif_key', $token)->first();

        if (empty($token) || ! $user) {
            session()->setFlashdata('error', lang('Auth.reset_token_invalid'));
            return redirect()->to("/{$locale}/auth/forgot-password");
        }

        $rules = [
            'password' => [
                'label' => 'Register.password',
                'rules' => 'required|min_length[6]|max_length[255]',
            ],
            'password_confirm' => [
                'label' => 'Register.password_confirm',
                'rules' => 'required|matches[password]',
            ],
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        helper('text');

        // Yeni şifreyi ayarla ve sıfırlama anahtarını yenileyerek eski token'ı geçersiz kıl (NULL hatasını önler)
        $user->setPassword((string) $this->request->getPost('password'));
        $user->setVerifKey(random_string('alnum', 32));

        $userModel->save($user);

        // 4. E-posta: Şifre başarıyla değiştirildi bildirim postası gönder
        $emailService = new EmailService();
        $emailService->sendPasswordResetSuccess($user);

        session()->setFlashdata('success', lang('Auth.reset_success'));
        return redirect()->to("/{$locale}/login");
    }
}
