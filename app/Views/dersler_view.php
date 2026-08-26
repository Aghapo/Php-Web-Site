<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ders Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    
    <!-- Üst Menü / Geri Dönüş -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📚 Ders Yönetimi</h2>
        <a href="/" class="btn btn-outline-secondary">← Öğrenci Listesine Dön</a>
    </div>

    <!-- Bildirim Mesajları -->
    <?php if(session()->has('basari')): ?>
        <div class="alert alert-success"><?= esc(session('basari')) ?></div>
    <?php endif; ?>
    <?php if(session()->has('hata')): ?>
        <div class="alert alert-danger"><?= esc(session('hata')) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- SOL TARAF: DERS EKLEME FORMU -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Yeni Ders Ekle</div>
                <div class="card-body">
                    <form action="/ders/kaydet" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Ders Adı</label>
                            <input type="text" name="ders_adi" class="form-control" placeholder="Örn: Biyoloji" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- SAĞ TARAF: DERSLER LİSTESİ -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Ders Adı</th>
                                <th class="text-end">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($dersler)): ?>
                                <?php foreach($dersler as $ders): ?>
                                <tr>
                                    <td><?= esc($ders['id']) ?></td>
                                    <td><strong><?= esc($ders['ders_adi']) ?></strong></td>
                                    <td class="text-end">
                                        <form action="/ders/sil/<?= esc($ders['id']) ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu dersi silmek istediğinize emin misiniz?');">Sil</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Henüz ders eklenmedi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
