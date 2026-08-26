<?= $this->extend('layouts/main') ?>

<?= $this->section('icerik') ?>

    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Yeni Öğrenci Ekle</h5>
            </div>
            <div class="card-body">
                
                <!-- Validation (Doğrulama) Hata Mesajları -->
                <?php if (session()->has('hatalar')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('hatalar') as $hata): ?>
                                <li><?= esc($hata) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <!-- Yukarıda hataları yazdırması için burasını kullanabilirsin.
                <?php if(session()->has('hatalar')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach(session('hatalar') as $hata): ?>
                                <li><?= esc($hata) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?> 
                 -->
                 
                <form action="/ogrenci/ekle" method="POST" enctype = "multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Ad</label>
                        
                        <input type="text" name="ad" class="form-control <?= session('hatalar.ad') ? 'is-invalid' : '' ?>" value="<?= old('ad') ?>">
                        
                        <?php if(session('hatalar.ad')): ?>
                            <div class= "invalid-feedback"><?= esc(session('hatalar.ad')) ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Soyad</label>
                        <input type="text" name="soyad" class="form-control <?= session('hatalar.soyad') ? 'is-invalid' : '' ?>" value="<?= old('soyad') ?>">
                        
                        <?php if(session('hatalar.soyad')): ?>
                            <div class= "invalid-feedback"><?= esc(session('hatalar.soyad')) ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aldığı dersler</label>
                        <?php foreach($dersler as $ders): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dersler[]" value="<?= esc($ders['id']) ?>" id="ders_<?= $ders['id'] ?>">
                                <label class="form-check-label" for="ders_<?= $ders['id'] ?>">
                                    <?= esc($ders['ders_adi']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profil Fotoğrafı</label>
                        <input type="file" name="foto" class="form-control <?= session('hatalar.foto') ? 'is-invalid' : '' ?>" accept="image/jpeg,image/png,image/webp">
                        
                        <?php if(session('hatalar.foto')): ?>
                            <div class="invalid-feedback">
                                <?= esc(session('hatalar.foto')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/" class="btn btn-secondary">İptal</a>
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
