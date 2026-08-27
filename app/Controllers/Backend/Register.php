<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Models\UserModel;

class Register extends BaseController
{
    /**
     * Standart kullanıcı kayıt sayfasını görüntüler (GET /register).
     */
    public function index()
    {
        return view('pagers/register', [
            'title'   => lang('Register.title'),
            'isAdmin' => false
        ]);
    }

    /**
     * Standart kullanıcı kayıt formunu işler (POST /register).
     */
    public function create()
    {
        $locale = $this->request->getLocale();

        // Config\Validation içindeki $userRegister kural grubunu doğrula
        if (! $this->validate('userRegister')) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        helper('text');

        // UserEntity nesnesini hazırla
        $user = new UserEntity();
        $user->setGroupId(2) // 2: Standart Kullanıcı Grubu
             ->setFirstName((string) $this->request->getPost('first_name'))
             ->setSurName((string) $this->request->getPost('sur_name'))
             ->setEmail((string) $this->request->getPost('email'))
             ->setPassword((string) $this->request->getPost('password'))
             ->setBio($this->request->getPost('bio') ? (string) $this->request->getPost('bio') : ($locale === 'tr' ? 'Biografinizi Yazabilirsiniz.' : 'Tell us about yourself.'))
             ->setVerifKey(random_string('alpha', 16))
             ->setVerifCode(random_int(100000, 999999))
             ->setStatus(defined('USER_ACTIVE') ? USER_ACTIVE : 'ACTIVE');

        $userModel = new UserModel();

        try {
            if (! $userModel->save($user)) {
                session()->setFlashdata('errors', $userModel->errors());
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $e) {
            log_message('error', 'Kayıt Hatası: {message}', ['message' => $e->getMessage()]);
            session()->setFlashdata('hata', 'Kayıt sırasında bir hata oluştu: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', lang('Register.success_message'));
        return redirect()->to('/' . $locale . '/register');
    }

    /**
     * Yönetici (Admin) kayıt sayfasını görüntüler (GET /register/admin).
     */
    public function admin()
    {
        return view('pagers/register', [
            'title'   => lang('Register.admin_title'),
            'isAdmin' => true
        ]);
    }

    /**
     * Yönetici (Admin) kayıt formunu işler ve kaydeder (POST /register/admin).
     */
    public function createAdmin()
    {
        $locale = $this->request->getLocale();

        // Config\Validation içindeki $adminRegister kural grubunu doğrula
        if (! $this->validate('adminRegister')) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        helper('text');

        // Admin UserEntity nesnesi oluştur
        $admin = new UserEntity();
        $admin->setGroupId(1) // 1: Süper Yönetici / Admin Grubu
              ->setFirstName((string) $this->request->getPost('first_name'))
              ->setSurName((string) $this->request->getPost('sur_name'))
              ->setEmail((string) $this->request->getPost('email'))
              ->setPassword((string) $this->request->getPost('password'))
              ->setBio($this->request->getPost('bio') ? (string) $this->request->getPost('bio') : ($locale === 'tr' ? 'Sistem Yöneticisi' : 'System Administrator'))
              ->setVerifKey(random_string('alpha', 16))
              ->setVerifCode(random_int(100000, 999999))
              ->setStatus(defined('USER_ACTIVE') ? USER_ACTIVE : 'ACTIVE');

        $userModel = new UserModel();

        try {
            if (! $userModel->save($admin)) {
                session()->setFlashdata('errors', $userModel->errors());
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $e) {
            log_message('error', 'Admin Kayıt Hatası: {message}', ['message' => $e->getMessage()]);
            session()->setFlashdata('hata', 'Yönetici kaydı sırasında hata oluştu: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', lang('Register.admin_success_message'));
        return redirect()->to('/' . $locale . '/register/admin');
    }
}
