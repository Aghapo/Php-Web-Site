<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc(lang('Login.title') ?? 'Giriş Yap | Öğrenci Takip Sistemi') ?></title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Özel CSS -->
    <link rel="stylesheet" href="/assets/css/register.css">
</head>
<body>

    <?php 
        $currentLocale = service('request')->getLocale();
        $errors = session('errors') ?? [];
    ?>

    <div class="register-container">
        <div class="register-card">

            <!-- Dil Seçici (Language Switcher) & Ana Sayfa Bağlantısı -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="/<?= $currentLocale ?>" class="text-decoration-none text-muted small">
                    <i class="bi bi-house-door-fill me-1"></i> <?= $currentLocale === 'tr' ? 'Ana Sayfa' : 'Home' ?>
                </a>
                <div class="btn-group btn-group-sm" role="group" aria-label="Language Selector">
                    <a href="/tr/login" class="btn btn-sm <?= ($currentLocale === 'tr') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">
                        🇹🇷 TR
                    </a>
                    <a href="/en/login" class="btn btn-sm <?= ($currentLocale === 'en') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">
                        🇬🇧 EN
                    </a>
                </div>
            </div>

            <!-- Başlık & İkon -->
            <div class="register-header">
                <div class="brand-icon">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <h1><?= $currentLocale === 'tr' ? 'Sisteme Giriş Yapın' : 'Log In to System' ?></h1>
                <p><?= $currentLocale === 'tr' ? 'Hesabınıza erişmek için bilgilerinizi giriniz.' : 'Enter your credentials to access your account.' ?></p>
            </div>

            <!-- Bildirimler (Hata ve Başarı Mesajları) -->
            <?= view('admin/layouts/partials/errors') ?>

            <!-- Giriş Formu -->
            <form action="/login/kontrol" method="POST" id="loginForm">
                <?= csrf_field() ?>

                <!-- Kullanıcı Adı veya E-Posta -->
                <div class="mb-3">
                    <label for="kullanici_adi" class="form-label">
                        <i class="bi bi-person-fill text-muted"></i> <?= $currentLocale === 'tr' ? 'Kullanıcı Adı veya E-Posta' : 'Username or Email' ?> <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="kullanici_adi" 
                           name="kullanici_adi" 
                           placeholder="<?= $currentLocale === 'tr' ? 'Kullanıcı adınız veya e-postanız' : 'Your username or email' ?>" 
                           value="<?= old('kullanici_adi') ?>" 
                           required>
                </div>

                <!-- Şifre -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="sifre" class="form-label mb-0">
                            <i class="bi bi-lock-fill text-muted"></i> <?= $currentLocale === 'tr' ? 'Şifre' : 'Password' ?> <span class="text-danger">*</span>
                        </label>
                        <!-- ŞİFREMİ UNUTTUM BAĞLANTISI -->
                        <a href="/<?= $currentLocale ?>/auth/forgot-password" class="small text-decoration-none fw-semibold text-primary">
                            <i class="bi bi-question-circle"></i> <?= $currentLocale === 'tr' ? 'Şifremi Unuttum?' : 'Forgot Password?' ?>
                        </a>
                    </div>
                    <div class="password-input-group">
                        <input type="password" 
                               class="form-control" 
                               id="sifre" 
                               name="sifre" 
                               placeholder="••••••••" 
                               required>
                        <button type="button" class="password-toggle-btn" data-target="sifre" aria-label="Toggle password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Giriş Butonu -->
                <button type="submit" class="btn-register mt-4" id="submitBtn">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span><?= $currentLocale === 'tr' ? 'Giriş Yap' : 'Log In' ?></span>
                </button>
            </form>

            <!-- Hızlı Kayıt & Yönetici Linkleri -->
            <div class="login-link-container d-flex flex-column gap-2 mt-4 pt-3 border-top">
                <div>
                    <?= $currentLocale === 'tr' ? 'Hesabınız yok mu?' : 'Don\'t have an account?' ?> 
                    <a href="/<?= $currentLocale ?>/register" class="fw-bold">
                        <?= $currentLocale === 'tr' ? 'Hemen Kayıt Olun' : 'Register Now' ?>
                    </a>
                </div>
                <div>
                    <a href="/<?= $currentLocale ?>/register/admin" class="text-muted small text-decoration-none">
                        <i class="bi bi-shield-lock"></i> <?= $currentLocale === 'tr' ? 'Yönetici (Admin) Kaydı' : 'Admin Registration' ?>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- JS Kütüphaneleri -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/register.js"></script>
</body>
</html>
