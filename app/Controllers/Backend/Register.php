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
            'title' => lang('Register.title')
        ]);
    }

    /**
     * Kayıt formundan gelen veriyi doğrular ve kullanıcıyı kaydeder.
     */
    public function create()
    {
        $locale = $this->request->getLocale();

        $rules = [
            'first_name' => [
                'label'  => lang('Register.first_name'),
                'rules'  => 'required|min_length[2]|max_length[155]',
            ],
            'sur_name' => [
                'label'  => lang('Register.sur_name'),
                'rules'  => 'required|min_length[2]|max_length[155]',
            ],
            'email' => [
                'label'  => lang('Register.email'),
                'rules'  => 'required|valid_email|is_unique[users.email]',
            ],
            'password' => [
                'label'  => lang('Register.password'),
                'rules'  => 'required|min_length[6]|max_length[255]',
            ],
            'password_confirm' => [
                'label'  => lang('Register.password_confirm'),
                'rules'  => 'required|matches[password]',
            ],
            'bio' => [
                'label' => lang('Register.bio'),
                'rules' => 'permit_empty|max_length[1000]',
            ],
            'terms' => [
                'label'  => lang('Register.terms'),
                'rules'  => 'required',
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
             ->setBio($this->request->getPost('bio') ? (string) $this->request->getPost('bio') : ($locale === 'tr' ? 'Biografinizi Yazabilirsiniz.' : 'Tell us about yourself.'))
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
        return redirect()->to('/' . $locale . '/register')->with('success', lang('Register.success_message'));
    }
}
