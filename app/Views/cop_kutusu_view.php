<?= $this->extend('layouts/main') ?>
<?= $this->section('icerik') ?> 

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-danger">🗑️ Çöp Kutusu</h3>
        <a href="/" class="btn btn-secondary">Ana Sayfaya Dön</a>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Ad Soyad</th>
                        <th>Silinme Tarihi</th>
                        <th width="15%" class="text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($ogrenciler)): ?>
                        <tr><td colspan="4" class="text-center">Çöp kutusu boş.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($ogrenciler as $kisi): ?>
                        <tr>
                            <td><?= esc($kisi['id']) ?></td>
                            <td><?= esc($kisi['ad']) ?> <?= esc($kisi['soyad']) ?></td>
                            <td><?= esc($kisi['deleted_at']) ?></td>
                            <td class="text-center">
                                <form action="/ogrenci/kurtar/<?= esc($kisi['id']) ?>" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-success btn-sm">Geri Yükle</button>
                                </form>
                                <form action="/kalici-sil/<?= esc($kisi['id']) ?>" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu öğrenciyi ve profil fotoğrafını kalıcı olarak silmek istediğinize emin misiniz? Bu işlem geri alınamaz!');">Kalıcı Sil</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
