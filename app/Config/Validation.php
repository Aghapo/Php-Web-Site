<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    /**
     * Standart Kullanıcı Kayıt Doğrulama Kuralları
     */
    public array $userRegister = [
        'first_name' => [
            'label' => 'Register.first_name',
            'rules' => 'required|min_length[2]|max_length[155]',
        ],
        'sur_name' => [
            'label' => 'Register.sur_name',
            'rules' => 'required|min_length[2]|max_length[155]',
        ],
        'email' => [
            'label' => 'Register.email',
            'rules' => 'required|valid_email|is_unique[users.email]',
        ],
        'password' => [
            'label' => 'Register.password',
            'rules' => 'required|min_length[6]|max_length[255]',
        ],
        'password_confirm' => [
            'label' => 'Register.password_confirm',
            'rules' => 'required|matches[password]',
        ],
        'bio' => [
            'label' => 'Register.bio',
            'rules' => 'permit_empty|max_length[1000]',
        ],
        'terms' => [
            'label' => 'Register.terms',
            'rules' => 'required',
        ],
    ];

    /**
     * Yönetici (Admin) Kayıt Doğrulama Kuralları
     */
    public array $adminRegister = [
        'first_name' => [
            'label' => 'Register.first_name',
            'rules' => 'required|min_length[2]|max_length[155]',
        ],
        'sur_name' => [
            'label' => 'Register.sur_name',
            'rules' => 'required|min_length[2]|max_length[155]',
        ],
        'email' => [
            'label' => 'Register.email',
            'rules' => 'required|valid_email|is_unique[users.email]',
        ],
        'password' => [
            'label' => 'Register.password',
            'rules' => 'required|min_length[6]|max_length[255]',
        ],
        'password_confirm' => [
            'label' => 'Register.password_confirm',
            'rules' => 'required|matches[password]',
        ],
        'admin_secret' => [
            'label' => 'Register.admin_secret',
            'rules' => 'permit_empty|min_length[4]|max_length[50]',
        ],
        'bio' => [
            'label' => 'Register.bio',
            'rules' => 'permit_empty|max_length[1000]',
        ],
        'terms' => [
            'label' => 'Register.terms',
            'rules' => 'required',
        ],
    ];
}
