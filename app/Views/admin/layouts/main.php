<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">
    <title>Öğrenci Bilgi Sistemi</title>
    
    <!-- Tüm projede geçerli olacak Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- YEŞİL BALONCUK (ALARM) BAŞLANGICI -->
    <?php if (session()->has('basari')): ?>
        <div id="basari-mesaji" class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg" style="z-index: 9999;" role="alert">
            <?= esc(session('basari')) ?> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
        </div>

        <script>
            setTimeout(function() {
                var mesaj = document.getElementById('basari-mesaji');
                if(mesaj) {
                    var bsAlert = new bootstrap.Alert(mesaj);
                    bsAlert.close();
                }
            }, 1500); // 1.5 saniye sonra kaybolur
        </script>
    <?php endif; ?>
    <?php if (session()->has('hata')): ?>
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg" style="z-index: 9999;" role="alert">
            <?= esc(session('hata')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
        </div>
    <?php endif; ?>
<!-- YEŞİL BALONCUK (ALARM) BİTİŞİ -->

    <!-- Üst Menü Alanı -->
    <?php $locale = service('request')->getLocale(); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/<?= $locale ?>">
                <i class="bi bi-mortarboard-fill text-primary me-2"></i>Öğrenci Bilgi Sistemi
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/<?= $locale ?>"><i class="bi bi-house-door"></i> Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/<?= $locale ?>/ogrenci/ekle"><i class="bi bi-person-plus"></i> Öğrenci Ekle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/<?= $locale ?>/dersler"><i class="bi bi-book"></i> Dersler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/<?= $locale ?>/ogrenci/cop_kutusu"><i class="bi bi-trash"></i> Çöp Kutusu</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Dil Seçici -->
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="/tr" class="btn btn-sm <?= ($locale === 'tr') ? 'btn-primary' : 'btn-outline-secondary' ?>">TR</a>
                        <a href="/en" class="btn btn-sm <?= ($locale === 'en') ? 'btn-primary' : 'btn-outline-secondary' ?>">EN</a>
                    </div>

                    <?php if (session()->get('giris_yapildi')): ?>
                        <span class="text-light small fw-medium">
                            <i class="bi bi-person-check-fill text-success"></i> <?= esc(session('admin_isim')) ?>
                        </span>
                        <form action="/logout" method="POST" class="mb-0">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Çıkış
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="/<?= $locale ?>/login" class="btn btn-outline-light btn-sm">Giriş Yap</a>
                        <a href="/<?= $locale ?>/register" class="btn btn-primary btn-sm">Kayıt Ol</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- DİNAMİK İÇERİK ALANI -->
    <!-- Diğer sayfalarımız tam olarak bu noktanın içine yerleşecek -->
    <?= $this->renderSection('icerik') ?>

    <!-- Tüm projede geçerli olacak Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>




<!-- ORTAK KUTU (Sadece çöp kutusu görünümüne ekle) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="basariToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div id="toastMesaji" class="toast-body fw-bold">
                <!-- Mesaj buraya gelecek -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="document.getElementById('basariToast').classList.remove('show')"></button>
        </div>
    </div>
</div>




<script>
function basariMesajiGoster(mesaj) {

    // Daha önce varsa eski mesajı kaldır
    let eskiMesaj = document.getElementById('basari-mesaji');

    if (eskiMesaj) {
        eskiMesaj.remove();
    }

    // Bootstrap alert oluştur
    let div = document.createElement('div');

    div.id = 'basari-mesaji';

    div.className =
        'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg';

    div.style.zIndex = '9999';

    div.setAttribute('role', 'alert');

    div.innerHTML = `
        ${mesaj}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    `;

    document.body.appendChild(div);

    // 1.5 saniye sonra kapat
    setTimeout(function () {

        let mesajElement = document.getElementById('basari-mesaji');

        if (mesajElement) {

            let bsAlert = new bootstrap.Alert(mesajElement);

            bsAlert.close();
        }

    }, 1500);
}
</script>


</html>
