<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? lang('Auth.reset_password_title')) ?> | Öğrenci Takip Sistemi</title>

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
                    <a href="/tr/auth/reset-password/<?= esc($token) ?>" class="btn btn-sm <?= ($currentLocale === 'tr') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">🇹🇷 TR</a>
                    <a href="/en/auth/reset-password/<?= esc($token) ?>" class="btn btn-sm <?= ($currentLocale === 'en') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">🇬🇧 EN</a>
                </div>
            </div>

            <!-- Başlık & İkon -->
            <div class="register-header">
                <div class="brand-icon" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h1><?= esc(lang('Auth.reset_password_title')) ?></h1>
                <p><?= esc(lang('Auth.reset_password_desc')) ?></p>
            </div>

            <!-- E-Posta Bilgi Kutucuğu -->
            <?php if (!empty($email)): ?>
                <div class="alert alert-light border d-flex align-items-center mb-4 py-2 px-3 rounded-3 shadow-sm">
                    <i class="bi bi-person-circle text-primary fs-5 me-2"></i>
                    <div>
                        <div class="text-muted" style="font-size: 11px;"><?= $currentLocale === 'tr' ? 'Hesap E-Postası' : 'Account Email' ?></div>
                        <strong class="text-dark"><?= esc($email) ?></strong>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Bildirimler -->
            <?= view('admin/layouts/partials/errors') ?>

            <!-- Form -->
            <form action="/<?= $currentLocale ?>/auth/reset-password/<?= esc($token) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock text-muted"></i> <?= esc(lang('Register.password')) ?> <span class="text-danger">*</span>
                    </label>
                    <div class="password-input-group">
                        <input type="password" 
                               class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••" 
                               required>
                        <button type="button" class="password-toggle-btn" data-target="password" aria-label="Toggle password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-meter">
                        <div class="strength-bar" id="strength-bar"></div>
                    </div>
                    <div class="strength-text" id="strength-text"></div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="password_confirm" class="form-label">
                        <i class="bi bi-shield-lock text-muted"></i> <?= esc(lang('Register.password_confirm')) ?> <span class="text-danger">*</span>
                    </label>
                    <div class="password-input-group">
                        <input type="password" 
                               class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                               id="password_confirm" 
                               name="password_confirm" 
                               placeholder="••••••••" 
                               required>
                        <button type="button" class="password-toggle-btn" data-target="password_confirm" aria-label="Toggle confirm password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-text" id="password-match-msg"></div>
                    <?php if (isset($errors['password_confirm'])): ?>
                        <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-register" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);" id="submitBtn">
                    <i class="bi bi-check-lg fs-5"></i>
                    <span><?= esc(lang('Auth.reset_submit_btn')) ?></span>
                </button>
            </form>

            <div class="login-link-container">
                <a href="/<?= $currentLocale ?>/login"><i class="bi bi-arrow-left me-1"></i> <?= esc(lang('Auth.back_to_login')) ?></a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/register.js"></script>
</body>
</html>
