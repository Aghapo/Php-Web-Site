<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sisteme Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow-lg" style="width: 400px;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Yönetici Girişi</h3>
            
            <!-- HATA MESAJI VARSA GÖSTER -->
            <?php if(session()->has('hata')): ?>
                <div class="alert alert-danger"><?= session('hata') ?></div>
            <?php endif; ?>

            <form action="/login/kontrol" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Kullanıcı Adı</label>
                    <input type="text" name="kullanici_adi" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Şifre</label>
                    <input type="password" name="sifre" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Giriş Yap</button>
            </form>
        </div>
    </div>

</body>
</html>
