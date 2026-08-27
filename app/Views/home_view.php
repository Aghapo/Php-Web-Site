<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= service('request')->getLocale() === 'tr' ? 'Öğrenci Bilgi & Yönetim Sistemi' : 'Student Management Platform' ?></title>

    <!-- Google Fonts & Bootstrap 5.3 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
        }
        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 60px 20px;
        }
        .portal-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 45px 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
        }
        .nav-btn-card {
            background: rgba(255, 255, 255, 0.035);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 26px 20px;
            text-align: center;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .nav-btn-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-6px);
            border-color: rgba(99, 102, 241, 0.55);
            box-shadow: 0 14px 30px rgba(99, 102, 241, 0.25);
            color: #ffffff;
        }
        .icon-box {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }
        .bg-indigo { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .bg-emerald { background: linear-gradient(135deg, #10b981, #059669); }
        .bg-amber  { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .bg-rose   { background: linear-gradient(135deg, #f43f5e, #e11d48); }
        .bg-cyan   { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .bg-purple { background: linear-gradient(135deg, #a855f7, #7e22ce); }
        .navbar-brand-badge {
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
    </style>
</head>
<body>

    <?php $locale = service('request')->getLocale(); ?>

    <!-- Üst Menü -->
    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3 border-bottom border-white border-opacity-10">
        <div class="container-fluid">
            <a class="navbar-brand fs-4" href="/<?= $locale ?>">
                <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                <span class="navbar-brand-badge">Öğrenci Bilgi Sistemi</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <!-- Dil Seçici -->
                <div class="btn-group btn-group-sm" role="group">
                    <a href="/tr" class="btn btn-sm <?= ($locale === 'tr') ? 'btn-primary' : 'btn-outline-secondary text-white' ?>">🇹🇷 TR</a>
                    <a href="/en" class="btn btn-sm <?= ($locale === 'en') ? 'btn-primary' : 'btn-outline-secondary text-white' ?>">🇬🇧 EN</a>
                </div>

                <?php if (session()->get('giris_yapildi')): ?>
                    <span class="text-white-50 small">
                        <i class="bi bi-person-circle me-1"></i> <?= esc(session('admin_isim')) ?>
                    </span>
                    <form action="/logout" method="POST" class="mb-0">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Çıkış
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Ana Gövde -->
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Bildirim Parçacığı -->
                    <?= view('admin/layouts/partials/errors') ?>

                    <div class="portal-card text-center mb-4">
                        <h1 class="display-6 fw-bold mb-2">
                            <?= $locale === 'tr' ? 'Öğrenci Bilgi ve Yönetim Sistemi' : 'Student Information & Management Platform' ?>
                        </h1>
                        <p class="text-white-50 mb-4 pb-2">
                            <?= $locale === 'tr' ? 'Kurumsal öğrenci takibi, ders yönetimi ve güvenli yetkilendirme paneli.' : 'Enterprise student tracking, curriculum management and secure authentication platform.' ?>
                        </p>

                        <!-- Hızlı Erişim Kartları Grid -->
                        <div class="row g-3 text-start">
                            
                            <!-- 1. Giriş Yap -->
                            <div class="col-md-4 col-sm-6">
                                <a href="/<?= $locale ?>/login" class="nav-btn-card">
                                    <div class="icon-box bg-indigo">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-1"><?= $locale === 'tr' ? 'Giriş Yap' : 'Log In' ?></h5>
                                    <span class="text-white-50 small"><?= $locale === 'tr' ? 'Kullanıcı veya yönetici oturumu' : 'User or admin session' ?></span>
                                </a>
                            </div>

                            <!-- 2. Kayıt Ol -->
                            <div class="col-md-4 col-sm-6">
                                <a href="/<?= $locale ?>/register" class="nav-btn-card">
                                    <div class="icon-box bg-emerald">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-1"><?= $locale === 'tr' ? 'Yeni Kayıt' : 'Register' ?></h5>
                                    <span class="text-white-50 small"><?= $locale === 'tr' ? 'Standart kullanıcı hesabı oluşturun' : 'Create standard user account' ?></span>
                                </a>
                            </div>

                            <!-- 3. Şifremi Unuttum -->
                            <div class="col-md-4 col-sm-6">
                                <a href="/<?= $locale ?>/auth/forgot-password" class="nav-btn-card">
                                    <div class="icon-box bg-amber">
                                        <i class="bi bi-key-fill"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-1"><?= $locale === 'tr' ? 'Şifremi Unuttum' : 'Forgot Password' ?></h5>
                                    <span class="text-white-50 small"><?= $locale === 'tr' ? 'E-posta ile güvenli şifre sıfırlama' : 'Secure email password reset' ?></span>
                                </a>
                            </div>

                            <!-- 4. Yönetici Kaydı -->
                            <div class="col-md-4 col-sm-6">
                                <a href="/<?= $locale ?>/register/admin" class="nav-btn-card">
                                    <div class="icon-box bg-rose">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-1"><?= $locale === 'tr' ? 'Yönetici Kaydı' : 'Admin Register' ?></h5>
                                    <span class="text-white-50 small"><?= $locale === 'tr' ? 'Yetkili yönetici hesabı tanımlayın' : 'Define authorized admin account' ?></span>
                                </a>
                            </div>

                            <!-- 5. Dersler -->
                            <div class="col-md-4 col-sm-6">
                                <a href="/<?= $locale ?>/dersler" class="nav-btn-card">
                                    <div class="icon-box bg-cyan">
                                        <i class="bi bi-book-half"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-1"><?= $locale === 'tr' ? 'Ders Yönetimi' : 'Curriculum' ?></h5>
                                    <span class="text-white-50 small"><?= $locale === 'tr' ? 'Ders ve müfredat listesi' : 'Course & curriculum list' ?></span>
                                </a>
                            </div>

                            <!-- 6. Öğrenci İşlemleri -->
                            <div class="col-md-4 col-sm-6">
                                <a href="/<?= $locale ?>/ogrenci/ekle" class="nav-btn-card">
                                    <div class="icon-box bg-purple">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-1"><?= $locale === 'tr' ? 'Öğrenci İşlemleri' : 'Students' ?></h5>
                                    <span class="text-white-50 small"><?= $locale === 'tr' ? 'Yeni öğrenci kaydı ve yönetimi' : 'Student records management' ?></span>
                                </a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Alt Bilgi -->
    <footer class="text-center py-3 text-white-50 small border-top border-white border-opacity-10">
        &copy; <?= date('Y') ?> Öğrenci Bilgi Sistemi. <?= $locale === 'tr' ? 'Tüm Hakları Saklıdır.' : 'All Rights Reserved.' ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
