<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('icerik') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <!-- Bildirimler -->
            <?= view('admin/layouts/partials/errors') ?>

            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                
                <!-- Kart Başlığı -->
                <div class="card-header bg-primary bg-gradient text-white p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Öğrenci Bilgilerini Güncelle</h4>
                            <small class="text-white-50">Kayıtlı öğrencinin bilgilerini düzenleyin.</small>
                        </div>
                    </div>
                    <a href="/" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="bi bi-arrow-left"></i> Geri Dön
                    </a>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    
                    <form action="/ogrenci/guncelle/<?= $ogrenci['id'] ?>" method="POST" enctype="multipart/form-data" id="studentEditForm">
                        <?= csrf_field() ?>

                        <!-- Ad & Soyad -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="ad" class="form-label fw-semibold">
                                    <i class="bi bi-person text-primary me-1"></i> Öğrenci Adı <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="ad"
                                       name="ad" 
                                       class="form-control form-control-lg fs-6 <?= session('hatalar.ad') ? 'is-invalid' : '' ?>" 
                                       placeholder="Örn: Ahmet" 
                                       value="<?= esc(old('ad', $ogrenci['ad'])) ?>" 
                                       required>
                                <?php if(session('hatalar.ad')): ?>
                                    <div class="invalid-feedback"><?= esc(session('hatalar.ad')) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label for="soyad" class="form-label fw-semibold">
                                    <i class="bi bi-person text-primary me-1"></i> Öğrenci Soyadı <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="soyad"
                                       name="soyad" 
                                       class="form-control form-control-lg fs-6 <?= session('hatalar.soyad') ? 'is-invalid' : '' ?>" 
                                       placeholder="Örn: Yılmaz" 
                                       value="<?= esc(old('soyad', $ogrenci['soyad'])) ?>" 
                                       required>
                                <?php if(session('hatalar.soyad')): ?>
                                    <div class="invalid-feedback"><?= esc(session('hatalar.soyad')) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Ders Seçimi -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">
                                <i class="bi bi-book text-primary me-1"></i> Aldığı Dersler
                            </label>
                            <div class="p-3 bg-light rounded-3 border">
                                <?php if(!empty($dersler)): ?>
                                    <div class="row g-2">
                                        <?php foreach($dersler as $ders): ?>
                                            <div class="col-md-6">
                                                <div class="form-check p-2 bg-white rounded border border-light-subtle shadow-2xs">
                                                    <input class="form-check-input ms-0 me-2" 
                                                           type="checkbox" 
                                                           name="dersler[]" 
                                                           value="<?= esc($ders['id']) ?>" 
                                                           id="ders_<?= $ders['id'] ?>"
                                                           <?= in_array($ders['id'], $secili_dersler ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-medium text-dark cursor-pointer" for="ders_<?= $ders['id'] ?>">
                                                        <?= esc($ders['ders_adi']) ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1"></i> Henüz kayıtlı ders bulunmuyor.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Profil Fotoğrafı Yükleme & Önizleme -->
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold">
                                <i class="bi bi-image text-primary me-1"></i> Profil Fotoğrafı
                            </label>
                            
                            <?php if(!empty($ogrenci['foto'])): ?>
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border mb-2">
                                    <img src="/uploads/<?= esc($ogrenci['foto']) ?>" width="55" height="55" class="rounded-circle object-fit-cover shadow-sm border" alt="Mevcut Fotoğraf">
                                    <div>
                                        <div class="fw-semibold small text-dark">Mevcut Fotoğraf</div>
                                        <small class="text-muted">Değiştirmek istemiyorsanız yeni dosya seçmeyin.</small>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="input-group">
                                <input type="file" 
                                       id="foto"
                                       name="foto" 
                                       class="form-control form-control-lg fs-6 <?= session('hatalar.foto') ? 'is-invalid' : '' ?>" 
                                       accept="image/jpeg,image/png,image/webp">
                            </div>
                            <?php if(session('hatalar.foto')): ?>
                                <div class="text-danger small mt-1"><?= esc(session('hatalar.foto')) ?></div>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <!-- Butonlar -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="/" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                <i class="bi bi-x-lg me-1"></i> İptal
                            </a>
                            <button type="submit" class="btn btn-primary bg-gradient px-5 py-2 fw-semibold rounded-3 shadow-sm">
                                <i class="bi bi-check2-circle fs-5 me-1 align-middle"></i> Güncellemeleri Kaydet
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
