<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? lang('Register.title')) ?> | Öğrenci Takip Sistemi</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Özel Register CSS -->
    <link rel="stylesheet" href="/assets/css/register.css">
</head>
<body>

    <?php 
        $currentLocale = service('request')->getLocale();
        $isAdmin = $isAdmin ?? false;
        $formAction = $isAdmin ? "/{$currentLocale}/register/admin" : "/{$currentLocale}/register";
        $trLink = $isAdmin ? "/tr/register/admin" : "/tr/register";
        $enLink = $isAdmin ? "/en/register/admin" : "/en/register";
        $errors = session('errors') ?? [];
    ?>

    <div class="register-container">
        <div class="register-card">

            <!-- Dil Seçici (Language Switcher) & Ana Sayfa Bağlantısı -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="/<?= $currentLocale ?>" class="text-decoration-none text-muted small">
                        <i class="bi bi-house-door-fill me-1"></i> <?= $currentLocale === 'tr' ? 'Ana Sayfa' : 'Home' ?>
                    </a>
                    <?php if ($isAdmin): ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill fw-semibold small">
                            <i class="bi bi-shield-lock-fill me-1"></i> <?= esc(lang('Register.admin_badge')) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="btn-group btn-group-sm" role="group" aria-label="Language Selector">
                    <a href="<?= $trLink ?>" class="btn btn-sm <?= ($currentLocale === 'tr') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">
                        🇹🇷 TR
                    </a>
                    <a href="<?= $enLink ?>" class="btn btn-sm <?= ($currentLocale === 'en') ? 'btn-primary text-white' : 'btn-outline-secondary' ?>">
                        🇬🇧 EN
                    </a>
                </div>
            </div>

            <!-- Başlık & Logo Alanı -->
            <div class="register-header">
                <div class="brand-icon <?= $isAdmin ? 'bg-danger' : '' ?>">
                    <i class="bi <?= $isAdmin ? 'bi-shield-check' : 'bi-person-plus-fill' ?>"></i>
                </div>
                <h1><?= esc($isAdmin ? lang('Register.admin_title') : lang('Register.title')) ?></h1>
                <p><?= esc($isAdmin ? lang('Register.admin_subtitle') : lang('Register.subtitle')) ?></p>
            </div>

            <!-- Ortak Hata ve Bildirim Parçacığı (Partials) -->
            <?= view('admin/layouts/partials/errors') ?>

            <!-- Kayıt Formu -->
            <form action="<?= $formAction ?>" method="POST" id="registerForm" novalidate>
                <?= csrf_field() ?>

                <div class="row g-3 mb-3">
                    <!-- Ad -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">
                            <i class="bi bi-person text-muted"></i> <?= esc(lang('Register.first_name')) ?> <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                               id="first_name" 
                               name="first_name" 
                               placeholder="<?= esc(lang('Register.first_name')) ?>" 
                               value="<?= old('first_name') ?>" 
                               required>
                        <?php if (isset($errors['first_name'])): ?>
                            <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Soyad -->
                    <div class="col-md-6">
                        <label for="sur_name" class="form-label">
                            <i class="bi bi-person text-muted"></i> <?= esc(lang('Register.sur_name')) ?> <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= isset($errors['sur_name']) ? 'is-invalid' : '' ?>" 
                               id="sur_name" 
                               name="sur_name" 
                               placeholder="<?= esc(lang('Register.sur_name')) ?>" 
                               value="<?= old('sur_name') ?>" 
                               required>
                        <?php if (isset($errors['sur_name'])): ?>
                            <div class="invalid-feedback"><?= $errors['sur_name'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- E-Posta -->
                <div class="mb-3">
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

                <div class="row g-3 mb-3">
                    <!-- Şifre -->
                    <div class="col-md-6">
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

                    <!-- Şifre Tekrarı -->
                    <div class="col-md-6">
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
                </div>

                <!-- Admin Güvenlik Kodu (Sadece Admin Kaydında) -->
                <?php if ($isAdmin): ?>
                    <div class="mb-3">
                        <label for="admin_secret" class="form-label">
                            <i class="bi bi-key text-muted"></i> <?= esc(lang('Register.admin_secret')) ?>
                        </label>
                        <input type="text" 
                               class="form-control <?= isset($errors['admin_secret']) ? 'is-invalid' : '' ?>" 
                               id="admin_secret" 
                               name="admin_secret" 
                               placeholder="<?= esc(lang('Register.admin_secret_placeholder')) ?>" 
                               value="<?= old('admin_secret') ?>">
                        <?php if (isset($errors['admin_secret'])): ?>
                            <div class="invalid-feedback"><?= $errors['admin_secret'] ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Biyografi (İsteğe Bağlı) -->
                <div class="mb-3">
                    <label for="bio" class="form-label">
                        <i class="bi bi-card-text text-muted"></i> <?= esc(lang('Register.bio')) ?> <span class="text-muted fw-normal">(<?= $currentLocale === 'tr' ? 'İsteğe Bağlı' : 'Optional' ?>)</span>
                    </label>
                    <textarea class="form-control <?= isset($errors['bio']) ? 'is-invalid' : '' ?>" 
                              id="bio" 
                              name="bio" 
                              rows="2" 
                              placeholder="<?= esc(lang('Register.bio_placeholder')) ?>"><?= old('bio') ?></textarea>
                    <?php if (isset($errors['bio'])): ?>
                        <div class="invalid-feedback"><?= $errors['bio'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Şartlar ve Koşullar -->
                <div class="mb-4 form-check">
                    <input type="checkbox" 
                           class="form-check-input <?= isset($errors['terms']) ? 'is-invalid' : '' ?>" 
                           id="terms" 
                           name="terms" 
                           value="1" 
                           <?= old('terms') ? 'checked' : '' ?> 
                           required>
                    <label class="form-check-label" for="terms">
                        <a href="#" tabindex="-1"><?= esc(lang('Register.terms')) ?></a> &amp; <a href="#" tabindex="-1"><?= esc(lang('Register.privacy')) ?></a>
                    </label>
                    <?php if (isset($errors['terms'])): ?>
                        <div class="invalid-feedback"><?= $errors['terms'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Kayıt Ol Butonu -->
                <button type="submit" class="btn-register <?= $isAdmin ? 'btn-danger bg-danger border-0' : '' ?>" id="submitBtn">
                    <i class="bi bi-check-lg fs-5"></i>
                    <span><?= esc($isAdmin ? lang('Register.admin_submit_btn') : lang('Register.submit_btn')) ?></span>
                </button>
            </form>

            <!-- Giriş Yap & Şifremi Unuttum Linkleri -->
            <div class="login-link-container d-flex flex-column gap-2 mt-4 pt-3 border-top">
                <div>
                    <?= esc(lang('Register.have_account')) ?> <a href="/<?= $currentLocale ?>/login" class="fw-bold"><?= esc(lang('Register.login')) ?></a>
                </div>
                <div>
                    <a href="/<?= $currentLocale ?>/auth/forgot-password" class="text-muted small text-decoration-none">
                        <i class="bi bi-question-circle"></i> <?= $currentLocale === 'tr' ? 'Şifrenizi mi unuttunuz?' : 'Forgot your password?' ?>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Özel Register JS -->
    <script src="/assets/js/register.js"></script>
</body>
</html>
