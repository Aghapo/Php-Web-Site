<?php

namespace App\Libraries;

use App\Entities\UserEntity;
use Config\Services;

class EmailService
{
    /**
     * E-posta gönderim motorunu hazırlar ve gönderici bilgilerini ayarlar.
     */
    protected function getEmailClient()
    {
        $email = Services::email();
        $emailConfig = config('Email');

        $email->setMailType('html');

        $fromEmail = !empty($emailConfig->fromEmail) ? $emailConfig->fromEmail : 'noreply@ogrencibilgisistemi.com';
        $fromName  = !empty($emailConfig->fromName) ? $emailConfig->fromName : lang('Email.app_name');

        $email->setFrom($fromEmail, $fromName);

        return $email;
    }

    /**
     * E-postayı güvenli şekilde göndermeyi dener ve hata durumunda loglar.
     */
    protected function sendEmail($email): bool
    {
        try {
            $result = $email->send(false);
            if (! $result) {
                log_message('notice', 'E-posta gönderilemedi (SMTP ayarlarınızı kontrol ediniz): ' . $email->printDebugger(['headers', 'subject']));
            }
            return (bool) $result;
        } catch (\Throwable $e) {
            log_message('error', 'E-posta gönderim hatası: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 1. Hesap Doğrulama E-postası Gönderir
     */
    public function sendAccountVerification(UserEntity $user): bool
    {
        $locale = service('request')->getLocale();
        $verifyUrl = site_url("{$locale}/auth/verify/" . $user->getVerifKey());

        $htmlBody = view('emails/account_verification', [
            'name'       => $user->getFullName() ?: $user->getFirstName(),
            'verifyUrl'  => $verifyUrl,
            'verifCode'  => $user->getVerifCode(),
        ]);

        $email = $this->getEmailClient();
        $email->setTo($user->getEmail());
        $email->setSubject(lang('Email.verification_subject'));
        $email->setMessage($htmlBody);

        return $this->sendEmail($email);
    }

    /**
     * 2. Hesap Doğrulandı Bildirim E-postası Gönderir
     */
    public function sendAccountVerified(UserEntity $user): bool
    {
        $locale = service('request')->getLocale();
        $loginUrl = site_url("{$locale}/login");

        $htmlBody = view('emails/account_verified', [
            'name'     => $user->getFullName() ?: $user->getFirstName(),
            'loginUrl' => $loginUrl,
        ]);

        $email = $this->getEmailClient();
        $email->setTo($user->getEmail());
        $email->setSubject(lang('Email.verified_subject'));
        $email->setMessage($htmlBody);

        return $this->sendEmail($email);
    }

    /**
     * 3. Şifre Sıfırlama Bağlantısı E-postası Gönderir
     */
    public function sendPasswordReset(UserEntity $user, string $token): bool
    {
        $locale = service('request')->getLocale();
        $resetUrl = site_url("{$locale}/auth/reset-password/{$token}");

        $htmlBody = view('emails/password_reset', [
            'name'     => $user->getFullName() ?: $user->getFirstName(),
            'resetUrl' => $resetUrl,
        ]);

        $email = $this->getEmailClient();
        $email->setTo($user->getEmail());
        $email->setSubject(lang('Email.reset_subject'));
        $email->setMessage($htmlBody);

        return $this->sendEmail($email);
    }

    /**
     * 4. Şifre Başarıyla Güncellendi Onay E-postası Gönderir
     */
    public function sendPasswordResetSuccess(UserEntity $user): bool
    {
        $locale = service('request')->getLocale();
        $loginUrl = site_url("{$locale}/login");

        $htmlBody = view('emails/password_reset_success', [
            'name'     => $user->getFullName() ?: $user->getFirstName(),
            'loginUrl' => $loginUrl,
        ]);

        $email = $this->getEmailClient();
        $email->setTo($user->getEmail());
        $email->setSubject(lang('Email.reset_success_subject'));
        $email->setMessage($htmlBody);

        return $this->sendEmail($email);
    }
}
