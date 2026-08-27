<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? lang('Auth.forgot_password_title')) ?> | Öğrenci Takip Sistemi</title>

    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/register.css">
</head>
<body>

    <?php 
        $currentLocale = service('request')->getLocale();
        $errors = session('errors') ?? [];
    ?>

    <div class="register-container">
        <div class="register-card">

            <!-- Dil Seçici & Ana Sayfa Bağlantısı -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="/<?= $currentLocale ?>" class="text-decoration-none text-muted small">
                    <i class="bi bi-house-door-fill me-1"></i> <?= $currentLocale === 'tr' ? 'Ana Sayfa' : 'Home' ?>
                </a>
                <div class="btn-group btn-group-sm" role="group">
                    <a href="/tr/auth/forgot-password" class="btn btn-sm <?= ($currentLocale === 'tr') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">🇹🇷 TR</a>
                    <a href="/en/auth/forgot-password" class="btn btn-sm <?= ($currentLocale === 'en') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">🇬🇧 EN</a>
                </div>
            </div>

            <!-- Başlık & İkon -->
            <div class="register-header">
                <div class="brand-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="bi bi-key-fill"></i>
                </div>
                <h1><?= esc(lang('Auth.forgot_password_title')) ?></h1>
                <p><?= esc(lang('Auth.forgot_password_desc')) ?></p>
            </div>

            <!-- Bildirimler -->
            <?= view('admin/layouts/partials/errors') ?>

            <!-- Form -->
            <form action="/<?= $currentLocale ?>/auth/forgot-password" method="POST">
                <?= csrf_field() ?>

                <div class="mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope text-muted"></i> <?= esc(lang('Register.email')) ?> <span class="text-danger">*</span>
                    </label>
                    <input type="email" 
                           class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                           id="email" 
                           name="email" 
                           placeholder="ornek@alanadi.com" 
                           value="<?= old('email') ?>" 
                           required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-register" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="bi bi-send-fill fs-6"></i>
                    <span><?= esc(lang('Auth.forgot_submit_btn')) ?></span>
                </button>
            </form>

            <!-- Hızlı Bağlantılar -->
            <div class="login-link-container d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="/<?= $currentLocale ?>/login" class="text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> <?= esc(lang('Auth.back_to_login')) ?>
                </a>
                <a href="/<?= $currentLocale ?>/register" class="text-decoration-none small fw-semibold">
                    <?= $currentLocale === 'tr' ? 'Hesap Oluştur' : 'Create Account' ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
