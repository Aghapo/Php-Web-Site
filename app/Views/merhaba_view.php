<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('icerik') ?>

<div class="container py-3">

    <!-- Sayfa Başlığı ve Hızlı İşlem Butonları -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-mortarboard text-primary me-2"></i>Öğrenci Yönetim Paneli
            </h2>
            <p class="text-muted mb-0 small">Kayıtlı öğrencileri listeleyin, düzenleyin ve not durumlarını yönetin.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="/ogrenci/ekle" class="btn btn-primary bg-gradient rounded-3 shadow-sm px-3 py-2 fw-semibold">
                <i class="bi bi-person-plus-fill me-1"></i> Yeni Öğrenci Ekle
            </a>
            <a href="/excel-aktar" class="btn btn-success bg-gradient rounded-3 shadow-sm px-3 py-2 fw-semibold">
                <i class="bi bi-file-earmark-excel-fill me-1"></i> Excel'e Aktar
            </a>
            <a href="/dersler" class="btn btn-info text-white bg-gradient rounded-3 shadow-sm px-3 py-2 fw-semibold">
                <i class="bi bi-book-fill me-1"></i> Dersler
            </a>
            <a href="/ogrenci/cop_kutusu" class="btn btn-outline-danger rounded-3 px-3 py-2" title="Çöp Kutusu">
                <i class="bi bi-trash3-fill"></i>
            </a>
        </div>
    </div>

    <!-- İSTATİSTİK KARTLARI -->
    <div class="row g-3 mb-4">
        <!-- Aktif Öğrenciler -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white bg-primary bg-gradient rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small fw-medium text-uppercase">Aktif Öğrenciler</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1"><?= esc($aktif_ogrenci_sayisi) ?></h2>
                        <small class="text-white-50">Sistemde kayıtlı öğrenci</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toplam Ders Sayısı -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white bg-success bg-gradient rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small fw-medium text-uppercase">Toplam Ders</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1"><?= esc($ders_sayisi) ?></h2>
                        <small class="text-white-50">Mevcut aktif dersler</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-journal-bookmark-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Çöp Kutusu -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-white bg-danger bg-gradient rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small fw-medium text-uppercase">Çöp Kutusu</span>
                        <h2 class="display-6 fw-bold mb-0 mt-1"><?= esc($silinmis_ogrenci_sayısı) ?></h2>
                        <small class="text-white-50">Silinmiş bekleyen kayıt</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-trash-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ARAMA ÇUBUĞU -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="/" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" 
                           name="kelime" 
                           class="form-control border-start-0 ps-0" 
                           placeholder="Öğrenci adı veya soyadı ile arama yapın..." 
                           value="<?= esc($arama_kelimesi ?? '') ?>">
                    <button class="btn btn-primary px-4 fw-semibold" type="submit">Ara</button>
                    <?php if(!empty($arama_kelimesi)): ?>
                        <a href="/" class="btn btn-outline-secondary px-3" title="Aramayı Temizle">
                            <i class="bi bi-x-lg"></i> Temizle
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- ÖĞRENCİ LİSTESİ TABLOSU -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-list-task text-primary me-2"></i>Kayıtlı Öğrenciler
            </h5>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">
                Toplam <?= count($ogrenciler) ?> Kayıt
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th scope="col" class="ps-4" width="8%">#ID</th>
                            <th scope="col" width="10%">Fotoğraf</th>
                            <th scope="col">Ad</th>
                            <th scope="col">Soyad</th>
                            <th scope="col">Kayıtlı Dersler</th>
                            <th scope="col" width="22%" class="text-center pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($ogrenciler)): ?>
                            <?php foreach ($ogrenciler as $kisi): ?>
                                <tr id="satir_<?= esc($kisi['id']) ?>">
                                    <td class="ps-4 fw-bold text-muted"><?= esc($kisi['id']) ?></td>
                                    <td>
                                        <?php if(!empty($kisi['foto'])): ?>
                                            <img src="/uploads/<?= esc($kisi['foto']) ?>" width="42" height="42" class="rounded-circle shadow-xs border" style="object-fit: cover;" alt="Avatar">
                                        <?php else: ?>
                                            <div class="bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                                <i class="bi bi-person-fill fs-5"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold text-dark"><?= esc($kisi['ad']) ?></td>
                                    <td class="fw-semibold text-dark"><?= esc($kisi['soyad']) ?></td>
                                    <td>
                                        <?php if(!empty($kisi['aldigi_dersler'])): ?>
                                            <span class="badge bg-light text-dark border fw-normal py-2 px-3">
                                                <i class="bi bi-journal-text text-primary me-1"></i> <?= esc($kisi['aldigi_dersler']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small">Ders Atanmadı</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="/ogrenci/duzenle/<?= $kisi['id'] ?>" class="btn btn-outline-primary" title="Düzenle">
                                                <i class="bi bi-pencil"></i> Düzenle
                                            </a>
                                            <a href="/ogrenci/<?= esc($kisi['id']) ?>/notlar" class="btn btn-outline-info" title="Notlar">
                                                <i class="bi bi-card-checklist"></i> Notlar
                                            </a>
                                            <button type="button" onclick="ogrenciSil(<?= esc($kisi['id']) ?>)" class="btn btn-outline-danger" title="Sil">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                    Kayıtlı öğrenci bulunamadı.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- SAYFALAMA -->
            <?php if(!empty($pager)): ?>
                <div class="d-flex justify-content-center p-3 border-top">
                    <?= $pager->links('default', 'bootstrap') ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<script>
function ogrenciSil(id) {
    if (confirm('Bu öğrenciyi silmek istediğinize emin misiniz?')) {
        fetch('/ogrenci/sil/' + id, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                [document.querySelector('meta[name="csrf-header"]').content]: document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.basari) {
                document.querySelector('meta[name="csrf-token"]').content = data.csrfHash;

                let satir = document.getElementById('satir_' + id);
                if (satir) {
                    satir.style.transition = "opacity 0.4s";
                    satir.style.opacity = "0";
                    setTimeout(() => { satir.remove(); }, 400);
                }

                basariMesajiGoster(data.mesaj);
            }
        })
        .catch(error => {
            alert('Silme işlemi sırasında bir hata oluştu.');
        });
    }
}
</script>

<?= $this->endSection() ?>
