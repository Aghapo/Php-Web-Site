<?php

namespace App\Models;

use App\Entities\UserEntity;
use \CodeIgniter\Model;


class UserModel extends Model 
{
        protected $table = 'users';
        protected $primaryKey = 'id';
        protected $returnType = UserEntity::class; 
        protected $useSoftDeletes = true;
        protected $allowedFields = [
            'group_id',
            'first_name',
            'sur_name',
            'email',
            'password',
            'verif_key',
            'verif_code',
            'bio',
            'status',
            'deleted_at'
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
        protected $deletedField = 'deleted_at';

        protected $validationRules = [
            'group_id'   => 'permit_empty|numeric',
            'first_name' => 'required|string|min_length[2]',
            'sur_name'   => 'required|string|min_length[2]',
            'email'      => 'required|valid_email|is_unique[users.email,id,{id}]',
            'password'   => 'permit_empty',
            'verif_key'  => 'permit_empty|alpha_numeric',
            'verif_code' => 'permit_empty|numeric',
            'status'     => 'permit_empty'
        ];
        
        protected $validationMessages = [
            'group_id' => [
                'required' => 'Grup ID zorunludur!',
                'numeric'  => 'Grup ID sadece rakamlardan oluşabilir!'
            ],
            'first_name' => [
                'required'   => 'İsim girilmesi zorunludur!',
                'string'     => 'İsim sadece metinsel karakterlerden oluşmalıdır!',
                'min_length' => 'İsim en az 3 karakter olmalıdır!'
            ],
            'sur_name' => [
                'required'   => 'Soyisim girilmesi zorunludur!',
                'string'     => 'Soyisim sadece metinsel karakterlerden oluşmalıdır!',
                'min_length' => 'Soyisim en az 3 karakter olmalıdır!'
            ],
            'email' => [
                'required'    => 'E-posta adresi zorunludur!',
                'valid_email' => 'Lütfen geçerli bir e-posta adresi giriniz!',
                'is_unique'   => 'Bu e-posta adresi zaten kullanılmaktadır!'
            ],
            'password' => [
                'required' => 'Şifre girilmesi zorunludur!'
            ],
            'verif_key' => [
                'required' => 'Doğrulama anahtarı zorunludur!',
                'alpha'    => 'Doğrulama anahtarı sadece harflerden oluşabilir!'
            ],
            'verif_code' => [
                'numeric'    => 'Doğrulama kodu sadece rakamlardan oluşmalıdır!',
                'min_length' => 'Doğrulama kodu en az 6 haneli olmalıdır!'
            ],
            'status' => [
                'required' => 'Kullanıcı durumu zorunludur!'
            ]
        ];
}
