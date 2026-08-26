<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kayıt Ol | Öğrenci Takip Sistemi') ?></title>

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

    <div class="register-container">
        <div class="register-card">

            <!-- Başlık & Logo Alanı -->
            <div class="register-header">
                <div class="brand-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h1>Yeni Hesap Oluşturun</h1>
                <p>Sisteme erişmek için bilgilerinizi eksiksiz doldurun.</p>
            </div>

            <!-- Başarı / Hata Bildirimleri -->
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div><?= session('success') ?></div>
                </div>
            <?php endif; ?>

            <?php if (session()->has('hata')): ?>
                <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div><?= session('hata') ?></div>
                </div>
            <?php endif; ?>

            <?php 
                $errors = session('errors') ?? [];
            ?>

            <!-- Kayıt Formu -->
            <form action="/register" method="POST" id="registerForm" novalidate>
                <?= csrf_field() ?>

                <div class="row g-3 mb-3">
                    <!-- Ad -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">
                            <i class="bi bi-person text-muted"></i> Ad <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                               id="first_name" 
                               name="first_name" 
                               placeholder="Adınız" 
                               value="<?= old('first_name') ?>" 
                               required>
                        <?php if (isset($errors['first_name'])): ?>
                            <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Soyad -->
                    <div class="col-md-6">
                        <label for="sur_name" class="form-label">
                            <i class="bi bi-person text-muted"></i> Soyad <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= isset($errors['sur_name']) ? 'is-invalid' : '' ?>" 
                               id="sur_name" 
                               name="sur_name" 
                               placeholder="Soyadınız" 
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
                        <i class="bi bi-envelope text-muted"></i> E-Posta Adresi <span class="text-danger">*</span>
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
                            <i class="bi bi-lock text-muted"></i> Şifre <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-group">
                            <input type="password" 
                                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                   id="password" 
                                   name="password" 
                                   placeholder="En az 6 karakter" 
                                   required>
                            <button type="button" class="password-toggle-btn" data-target="password">
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
                            <i class="bi bi-shield-lock text-muted"></i> Şifre Tekrarı <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-group">
                            <input type="password" 
                                   class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                   id="password_confirm" 
                                   name="password_confirm" 
                                   placeholder="Şifrenizi tekrar girin" 
                                   required>
                            <button type="button" class="password-toggle-btn" data-target="password_confirm">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="strength-text" id="password-match-msg"></div>
                        <?php if (isset($errors['password_confirm'])): ?>
                            <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Biyografi (İsteğe Bağlı) -->
                <div class="mb-3">
                    <label for="bio" class="form-label">
                        <i class="bi bi-card-text text-muted"></i> Biyografi <span class="text-muted fw-normal">(İsteğe Bağlı)</span>
                    </label>
                    <textarea class="form-control <?= isset($errors['bio']) ? 'is-invalid' : '' ?>" 
                              id="bio" 
                              name="bio" 
                              rows="2" 
                              placeholder="Kendiniz hakkında kısa bilgi yazabilirsiniz..."><?= old('bio') ?></textarea>
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
                        <a href="#" tabindex="-1">Kullanım Koşulları</a> ve <a href="#" tabindex="-1">Gizlilik Politikası</a>'nı okudum, kabul ediyorum.
                    </label>
                    <?php if (isset($errors['terms'])): ?>
                        <div class="invalid-feedback"><?= $errors['terms'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Kayıt Ol Butonu -->
                <button type="submit" class="btn-register" id="submitBtn">
                    <i class="bi bi-check-lg fs-5"></i>
                    <span>Hesabımı Oluştur</span>
                </button>
            </form>

            <!-- Giriş Yap Linki -->
            <div class="login-link-container">
                Zaten bir hesabınız var mı? <a href="/login">Giriş Yap</a>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Özel Register JS -->
    <script src="/assets/js/register.js"></script>
</body>
</html>
