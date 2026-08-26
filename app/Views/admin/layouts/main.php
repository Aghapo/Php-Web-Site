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
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Öğrenci Bilgi Sistemi</a>
            <form action="/logout" method="POST" class="mb-0">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger btn-sm">Çıkış Yap</button>
            </form>
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
