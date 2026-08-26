<?php

return [
    'model' => [
        'validation' => [
            'group_id' => [
                'required' => 'Group ID is required!',
                'numeric'  => 'Group ID must contain only numbers!'
            ],
            'first_name' => [
                'required'   => 'First name is required!',
                'string'     => 'First name must contain only characters!',
                'min_length' => 'First name must be at least 3 characters long!'
            ],
            'sur_name' => [
                'required'   => 'Surname is required!',
                'string'     => 'Surname must contain only characters!',
                'min_length' => 'Surname must be at least 3 characters long!'
            ],
            'email' => [
                'required'    => 'Email address is required!',
                'valid_email' => 'Please enter a valid email address!',
                'is_unique'   => 'This email address is already in use!'
            ],
            'password' => [
                'required' => 'Password is required!'
            ],
            'verif_key' => [
                'required' => 'Verification key is required!',
                'alpha'    => 'Verification key must contain only alphabetic characters!'
            ],
            'verif_code' => [
                'numeric'    => 'Verification code must contain only numbers!',
                'min_length' => 'Verification code must be at least 6 digits long!'
            ],
            'status' => [
                'required' => 'Status is required!'
            ]
        ]
    ]
];