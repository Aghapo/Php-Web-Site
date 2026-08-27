<?php

return [
    'model' => [
        'validation' => [
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
        ]
    ]
];