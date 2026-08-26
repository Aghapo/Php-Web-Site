<?= $this->extend('layouts/main') ?>

<?= $this->section('icerik') ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Not Takibi</h2>
            <p class="text-muted mb-0"><?= esc($ogrenci['ad']) ?> <?= esc($ogrenci['soyad']) ?></p>
        </div>
        <a href="/" class="btn btn-outline-secondary">Öğrenci Listesine Dön</a>
    </div>

    <?php if (session()->has('hatalar')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('hatalar') as $hata): ?>
                    <li><?= esc($hata) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Yeni Not Ekle</div>
                <div class="card-body">
                    <?php if (empty($dersler)): ?>
                        <p class="text-muted mb-0">Bu öğrenciye önce ders atamalısın.</p>
                    <?php else: ?>
                        <form action="/ogrenci/<?= esc($ogrenci['id']) ?>/notlar" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="ders_id" class="form-label">Ders</label>
                                <select id="ders_id" name="ders_id" class="form-select" required>
                                    <option value="">Ders seç</option>
                                    <?php foreach ($dersler as $ders): ?>
                                        <option value="<?= esc($ders['id']) ?>" <?= old('ders_id') == $ders['id'] ? 'selected' : '' ?>>
                                            <?= esc($ders['ders_adi']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sinav_turu" class="form-label">Değerlendirme</label>
                                <select id="sinav_turu" name="sinav_turu" class="form-select" required>
                                    <?php foreach (['vize' => 'Vize', 'final' => 'Final', 'kisa_sinav' => 'Kısa Sınav', 'odev' => 'Ödev'] as $deger => $etiket): ?>
                                        <option value="<?= esc($deger) ?>" <?= old('sinav_turu', 'vize') === $deger ? 'selected' : '' ?>><?= esc($etiket) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="puan" class="form-label">Puan</label>
                                <input id="puan" name="puan" type="number" min="0" max="100" step="0.01" class="form-control" value="<?= esc(old('puan')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="sinav_tarihi" class="form-label">Tarih</label>
                                <input id="sinav_tarihi" name="sinav_tarihi" type="date" class="form-control" value="<?= esc(old('sinav_tarihi', date('Y-m-d'))) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Notu Kaydet</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">Ders Ortalamaları</div>
                <div class="card-body">
                    <?php if (empty($dersOrtalamalari)): ?>
                        <span class="text-muted">Henüz not girilmedi.</span>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($dersOrtalamalari as $ortalama): ?>
                                <?php $basarili = (float) $ortalama['ortalama'] >= 50; ?>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="small text-muted"><?= esc($ortalama['ders_adi']) ?></div>
                                        <div class="fs-4 fw-bold <?= $basarili ? 'text-success' : 'text-danger' ?>">
                                            <?= esc(number_format((float) $ortalama['ortalama'], 2, ',', '.')) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">Not Geçmişi</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ders</th>
                                    <th>Tür</th>
                                    <th>Puan</th>
                                    <th>Tarih</th>
                                    <th class="text-end">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($notlar)): ?>
                                    <tr><td colspan="5" class="text-center text-muted py-4">Henüz not girilmedi.</td></tr>
                                <?php endif; ?>
                                <?php foreach ($notlar as $not): ?>
                                    <tr>
                                        <td><?= esc($not['ders_adi']) ?></td>
                                        <td><?= esc(['vize' => 'Vize', 'final' => 'Final', 'kisa_sinav' => 'Kısa Sınav', 'odev' => 'Ödev'][$not['sinav_turu']] ?? $not['sinav_turu']) ?></td>
                                        <td><?= esc(number_format((float) $not['puan'], 2, ',', '.')) ?></td>
                                        <td><?= esc($not['sinav_tarihi']) ?></td>
                                        <td class="text-end">
                                            <form action="/not/sil/<?= esc($not['id']) ?>" method="POST" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bu notu silmek istediğinize emin misiniz?');">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
