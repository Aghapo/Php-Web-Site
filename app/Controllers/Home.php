<?php 

namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
    /**
     * Ana Sayfa (Landing / Hızlı Erişim Portalı)
     */
    public function index()
    {
        return view('home_view');
    }

    /**
     * SMTP E-Posta Test Fonksiyonu
     * Tarayıcıdan http://localhost:8080/test-mail adresine girerek SMTP bağlantınızı test edebilirsiniz.
     */
    public function testMail()
    {
        $email = Services::email();
        $emailConfig = config('Email');

        $toEmail = !empty($emailConfig->SMTPUser) ? $emailConfig->SMTPUser : $emailConfig->fromEmail;

        $email->setTo($toEmail);
        $email->setSubject('E-Posta Test Bildirimi | ' . date('H:i:s'));
        $email->setMessage('
            <div style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
                <h2 style="color: #10b981;">🎉 Tebrikler! E-Posta Ayarlarınız Çalışıyor</h2>
                <p>Bu mesaj, CodeIgniter 4 SMTP e-posta ayarlarınızın doğru yapılandırıldığını doğrulamak için gönderilmiştir.</p>
                <hr>
                <small style="color: #666;">Zaman Damgası: ' . date('Y-m-d H:i:s') . '</small>
            </div>
        ');

        if ($email->send(false)) {
            return '
                <div style="font-family: sans-serif; max-width: 600px; margin: 50px auto; padding: 25px; border-radius: 12px; background: #ecfdf5; border: 1px solid #10b981; color: #065f46;">
                    <h2>✅ E-Posta Başarıyla Gönderildi!</h2>
                    <p>SMTP ayarlarınız tamamen doğru çalışıyor. E-posta <strong>' . esc($toEmail) . '</strong> adresine teslim edildi.</p>
                    <a href="/" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px;">Ana Sayfaya Dön</a>
                </div>
            ';
        } else {
            return '
                <div style="font-family: sans-serif; max-width: 700px; margin: 50px auto; padding: 25px; border-radius: 12px; background: #fef2f2; border: 1px solid #ef4444; color: #991b1b;">
                    <h2>❌ E-Posta Gönderilemedi!</h2>
                    <p>Lütfen <strong>.env</strong> dosyasındaki SMTP kullanıcı adı ve şifrenizi kontrol ediniz.</p>
                    <h4>Sunucu Hata Raporu:</h4>
                    <pre style="background: #ffffff; padding: 15px; border-radius: 8px; border: 1px solid #fecaca; overflow: auto; font-size: 13px;">' . esc($email->printDebugger(['headers', 'subject', 'body'])) . '</pre>
                    <a href="/" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #ef4444; color: white; text-decoration: none; border-radius: 6px;">Ana Sayfaya Dön</a>
                </div>
            ';
        }
    }
}
