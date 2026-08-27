<?php

return [
    // General
    'app_name'                => 'Student Tracking System',
    'greeting'                => 'Hello {name},',
    'footer_notice'           => 'This is an automated email. Please do not reply.',
    'rights_reserved'         => 'All rights reserved.',

    // 1. Account Verification Email
    'verification_subject'    => 'Account Verification Link',
    'verification_title'      => 'Welcome Aboard!',
    'verification_text'       => 'Your account has been successfully created. For your security, please verify your email address by clicking the button below.',
    'verification_code_text'  => 'Or you can use your verification code:',
    'verification_btn'        => 'Verify My Account',
    'verification_expire'     => 'This link is valid for 24 hours for security reasons.',

    // 2. Account Verified Email
    'verified_subject'        => 'Your Account Has Been Verified!',
    'verified_title'          => 'Congratulations, Your Account is Active!',
    'verified_text'           => 'Your email address has been successfully verified. You can now use all features of the Student Tracking System.',
    'verified_btn'            => 'Log In to the System',

    // 3. Password Reset Email
    'reset_subject'           => 'Password Reset Request',
    'reset_title'             => 'Forgot Your Password?',
    'reset_text'              => 'You have requested to reset your password. Click the button below to set a new password.',
    'reset_btn'               => 'Reset My Password',
    'reset_warning'           => 'If you did not request this, please ignore this email. Your password will remain unchanged.',
    'reset_expire'            => 'This link is valid for 1 hour.',

    // 4. Password Reset Success Email
    'reset_success_subject'   => 'Your Password Has Been Successfully Changed',
    'reset_success_title'     => 'Password Changed',
    'reset_success_text'      => 'Your account password has been updated successfully. You can now log in with your new password.',
    'reset_success_warning'   => 'If you did not perform this action, please contact the system administrator immediately.',
    'reset_success_btn'       => 'Log In',
];
