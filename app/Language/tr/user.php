<?php

return [
    'model' => [
        'validation' => [
            'group_id' => [
                'required' => 'User.model.validation.group_id.required',
                'numeric'  => 'User.model.validation.group_id.numeric'
            ],
            'first_name' => [
                'required'   => 'User.model.validation.first_name.required',
                'string'     => 'User.model.validation.first_name.string',
                'min_length' => 'User.model.validation.first_name.min_length'
            ],
            'sur_name' => [
                'required'   => 'User.model.validation.sur_name.required',
                'string'     => 'User.model.validation.sur_name.string',
                'min_length' => 'User.model.validation.sur_name.min_length'
            ],
            'email' => [
                'required'    => 'User.model.validation.email.required',
                'valid_email' => 'User.model.validation.email.valid_email',
                'is_unique'   => 'User.model.validation.email.is_unique'
            ],
            'password' => [
                'required' => 'User.model.validation.password.required'
            ],
            'verif_key' => [
                'required' => 'User.model.validation.verif_key.required',
                'alpha'    => 'User.model.validation.verif_key.alpha'
            ],
            'verif_code' => [
                'numeric'    => 'User.model.validation.verif_code.numeric',
                'min_length' => 'User.model.validation.verif_code.min_length'
            ],
            'status' => [
                'required' => 'User.model.validation.status.required'
            ]
        ]
    ]
];