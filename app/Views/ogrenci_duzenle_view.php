<?= $this->extend('layouts/main') ?>

<?= $this->section('icerik') ?>

    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Öğrenci Bilgilerini Güncelle</h5>
            </div>
            <div class="card-body">
                <?php if (session()->has('hatalar')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('hatalar') as $hata): ?>
                                <li><?= esc($hata) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/ogrenci/guncelle/<?= $ogrenci['id'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Öğrenci Adı</label>
                        <!-- Veritabanından gelen veriyi value içine yazdırıyoruz -->
                        <input type="text" name="ad" class="form-control <?= session('hatalar.ad') ? 'is-invalid' : '' ?>" value="<?= esc(old('ad', $ogrenci['ad'])) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Öğrenci Soyadı</label>
                        <input type="text" name="soyad" class="form-control <?= session('hatalar.soyad') ? 'is-invalid' : '' ?>" value="<?= esc(old('soyad', $ogrenci['soyad'])) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aldığı Dersler</label>
                        <?php foreach($dersler as $ders): ?>
                            <div class="form-check"> 
                                <input class="form-check-input" type="checkbox" name="dersler[]" value="<?= esc($ders['id']) ?>" id="ders_<?= $ders['id'] ?>" <?= in_array($ders['id'], $secili_dersler) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="ders_<?= $ders['id'] ?>">
                                    <?= esc($ders['ders_adi']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profil Fotoğrafı</label>
                        <input type="file" name="foto" class="form-control <?= session('hatalar.foto') ? 'is-invalid' : '' ?>" accept="image/jpeg,image/png,image/webp">
                        
                        <!-- Eski fotoğraf varsa ekranda küçük bir önizlemesini göster -->
                        <?php if(!empty($ogrenci['foto'])): ?>
                            <div class="mt-2">
                                <small class="text-muted">Mevcut Fotoğraf:</small><br>
                                <img src="/uploads/<?= esc($ogrenci['foto']) ?>" width="60" class="rounded shadow-sm">
                            </div>
                        <?php endif; ?>
                    </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/" class="btn btn-secondary">İptal</a>
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
