<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Models\UserModel;

class Register extends BaseController
{
    /**
     * Kayıt sayfasını görüntüler.
     */
    public function index()
    {
        return view('pagers/register', [
            'title' => 'Kayıt Ol | Öğrenci Takip Sistemi'
        ]);
    }

    /**
     * Kayıt formundan gelen veriyi doğrular ve kullanıcıyı kaydeder.
     */
    public function create()
    {
        $rules = [
            'first_name' => [
                'label'  => 'Ad',
                'rules'  => 'required|min_length[2]|max_length[155]',
                'errors' => [
                    'required'   => 'Ad alanı zorunludur.',
                    'min_length' => 'Ad en az 2 karakter olmalıdır.',
                    'max_length' => 'Ad en fazla 155 karakter olabilir.'
                ]
            ],
            'sur_name' => [
                'label'  => 'Soyad',
                'rules'  => 'required|min_length[2]|max_length[155]',
                'errors' => [
                    'required'   => 'Soyad alanı zorunludur.',
                    'min_length' => 'Soyad en az 2 karakter olmalıdır.',
                    'max_length' => 'Soyad en fazla 155 karakter olabilir.'
                ]
            ],
            'email' => [
                'label'  => 'E-Posta',
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'E-posta adresi zorunludur.',
                    'valid_email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
                    'is_unique'   => 'Bu e-posta adresi zaten kullanılmaktadır.'
                ]
            ],
            'password' => [
                'label'  => 'Şifre',
                'rules'  => 'required|min_length[6]|max_length[255]',
                'errors' => [
                    'required'   => 'Şifre alanı zorunludur.',
                    'min_length' => 'Şifre en az 6 karakter olmalıdır.',
                    'max_length' => 'Şifre en fazla 255 karakter olabilir.'
                ]
            ],
            'password_confirm' => [
                'label'  => 'Şifre Tekrarı',
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Şifre tekrarı alanı zorunludur.',
                    'matches'  => 'Girdiğiniz şifreler birbiriyle eşleşmiyor.'
                ]
            ],
            'bio' => [
                'label' => 'Biyografi',
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'Biyografi en fazla 1000 karakter olabilir.'
                ]
            ],
            'terms' => [
                'label'  => 'Kullanım Koşulları',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kayıt olmak için kullanım koşullarını kabul etmelisiniz.'
                ]
            ]
        ];

        // 1. Doğrulama Kontrolü
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        helper('text');

        // 2. UserEntity Nesnesini Hazırlama
        $user = new UserEntity();
        $user->setFirstName((string) $this->request->getPost('first_name'))
             ->setSurName((string) $this->request->getPost('sur_name'))
             ->setEmail((string) $this->request->getPost('email'))
             ->setPassword((string) $this->request->getPost('password'))
             ->setBio($this->request->getPost('bio') ? (string) $this->request->getPost('bio') : 'Biografinizi Yazabilirsiniz.')
             ->setVerifKey(random_string('alpha', 16))
             ->setVerifCode(random_int(100000, 999999))
             ->setStatus(defined('USER_ACTIVE') ? USER_ACTIVE : 'ACTIVE');

        // 3. Veritabanına Kaydetme
        $userModel = new UserModel();
        try {
            if (! $userModel->save($user)) {
                return redirect()->back()->withInput()->with('errors', $userModel->errors());
            }
        } catch (\Throwable $e) {
            log_message('error', 'Kayıt sırasında hata: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('hata', 'Kayıt sırasında bir hata oluştu: ' . $e->getMessage());
        }

        // 4. Başarılı Sonuç
        return redirect()->to('/register')->with('success', 'Hesabınız başarıyla oluşturuldu! Şimdi giriş yapabilirsiniz.');
    }
}
