<!DOCTYPE html>
<html lang="tr">
<!-- 1. Hangi şablonu kullanacağımızı söylüyoruz -->
<?= $this->extend('layouts/main') ?>

<!-- 2. Şablondaki 'icerik' bölümüne ne göndereceğimizi yazıyoruz -->
<?= $this->section('icerik') ?>

    <div class="container">
        <h1 class="text-primary mb-4"><?= esc($sayfa_basligi) ?></h1>

        
    <!-- ARAMA ÇUBUĞU BAŞLANGICI -->
    <form action="/" method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="kelime" class="form-control form-control-lg" placeholder="Öğrenci adı veya soyadı ara..." value="<?= esc($arama_kelimesi ?? '') ?>">
            <button class="btn btn-primary px-4" type="submit">Ara</button>
            
            <!-- Eğer arama yapılmışsa "Temizle" butonu çıksın -->
            <?php if(!empty($arama_kelimesi)): ?>
                <a href="/" class="btn btn-danger px-4">Temizle</a>
            <?php endif; ?>
        </div>
    </form>
    <!-- ARAMA ÇUBUĞU BİTİŞİ -->



        <!-- İSTATİSTİK KARTLARI -->
        <div class="row mb-4">
            <!-- Aktif Öğrenciler Kartı -->
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow">
                    <div class="card-body">
                        <h5 class="card-title">Aktif Öğrenciler</h5>
                        <h2 class="display-5 fw-bold"><?= esc($aktif_ogrenci_sayisi) ?></h2>
                        <p class="card-text">Sistemde kayıtlı toplam öğrenci</p>
                    </div>
                </div>
            </div>

            <!-- Toplam Ders Kartı -->
            <div class="col-md-4">
                <div class="card text-white bg-success shadow">
                    <div class="card-body">
                        <h5 class="card-title">Toplam Ders Sayısı</h5>
                        <h2 class="display-5 fw-bold"><?= esc($ders_sayisi) ?></h2>
                        <p class="card-text">Sistemde açılan mevcut dersler</p>
                    </div>
                </div>
            </div>

            <!-- Çöp Kutusu Kartı -->
            <div class="col-md-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Çöp Kutusu</h5>
                        <h2 class="display-5 fw-bold"><?= esc($silinmis_ogrenci_sayısı) ?></h2>
                        <p class="card-text">Silinmiş bekleyen öğrenci kaydı</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- İSTATİSTİK KARTLARI BİTİŞ -->



        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Öğrenci Listesi</h5>
                <a href="/ogrenci/ekle" class="btn btn-success btn-sm">+ Yeni Öğrenci Ekle</a>
                <a href="/ogrenci/cop_kutusu/" class= "btn btn-danger btn-sm"> 🗑️  </a>
                <a href="/excel-aktar" class="btn btn-success  btn-sm">📥 Excel'e Aktar</a>
                <a href="/dersler" class="btn btn-info text-white fw-bold">📚 Dersleri Yönet </a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Foto</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Ders</th>
                            <th width="20%" class="text-center">İşlemler</th>
                    </thead>
                    <tbody>
                        <?php foreach ($ogrenciler as $kisi): ?>
                            <tr id="satir_<?= esc($kisi['id']) ?>">
                                <td><?= esc($kisi['id']) ?></td>
                                <td>
                                    <?php if(!empty($kisi['foto'])): ?>
                                        <img src="/uploads/<?= esc($kisi['foto']) ?>" width="40" height="40" class="rounded-circle shadow-sm" style="object-fit: cover;">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Yok</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($kisi['ad']) ?></td>
                                <td><?= esc($kisi['soyad']) ?></td>
                                
                                <td>
                                    <?php if(!empty($kisi['aldigi_dersler'])): ?>
                                        <?= esc($kisi['aldigi_dersler']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Ders Seçilmedi</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <a href="/ogrenci/duzenle/<?= $kisi['id'] ?>" class="btn btn-primary btn-sm">Düzenle</a>
                                    <a href="/ogrenci/<?= esc($kisi['id']) ?>/notlar" class="btn btn-info btn-sm text-white">Notlar</a>
                                    <button type="button" onclick="ogrenciSil(<?= esc($kisi['id']) ?>)" class="btn btn-danger btn-sm">Sil</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- SAYFALAMA BUTONLARI BAŞLANGICI -->
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links('default', 'bootstrap') ?>
                </div>
                <!-- SAYFALAMA BUTONLARI BİTİŞİ -->
            </div>
        </div>
    </div>

<!-- 3. İçerik bölümünün bittiğini söylüyoruz -->

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

                // Satırı bul
                let satir = document.getElementById('satir_' + id);

                // Satırı sil
                satir.style.transition = "opacity 0.5s";
                satir.style.opacity = "0";

                setTimeout(() => {
                    satir.remove();
                }, 500);

                // Başarı mesajını göster
                basariMesajiGoster(data.mesaj);
            }
        })
        .catch(error => {
            alert('Bir hata oluştu!');
        });
    }
}
</script>
<?= $this->endSection() ?>
</html>
