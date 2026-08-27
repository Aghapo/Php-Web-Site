<?php
/**
 * Modern Uyarı & Hata Yakalama Parçacığı (Alerts & Errors Partial)
 * Bu dosya session üzerinden gelen başarı, hata, uyarı ve doğrulama hatalarını modern bir şekilde listeler.
 */
?>

<!-- Başarı Bildirimi (Success Alert) -->
<?php if (session()->has('success') || session()->has('basari')): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm border-0 mb-4" role="alert" style="border-radius: 0.85rem; background-color: #ecfdf5; border-left: 4px solid #10b981 !important;">
        <i class="bi bi-check-circle-fill text-success fs-5 me-3 flex-shrink-0"></i>
        <div class="text-success fw-medium">
            <?= esc(session('success') ?? session('basari')) ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
<?php endif; ?>

<!-- Tekil Hata Bildirimi (Single Error Alert) -->
<?php if (session()->has('error') || session()->has('hata')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm border-0 mb-4" role="alert" style="border-radius: 0.85rem; background-color: #fef2f2; border-left: 4px solid #ef4444 !important;">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-3 flex-shrink-0"></i>
        <div class="text-danger fw-medium">
            <?= esc(session('error') ?? session('hata')) ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
<?php endif; ?>

<!-- Çoklu Doğrulama Hataları (Validation Errors List) -->
<?php if (session()->has('errors')): ?>
    <?php 
        $errors = session('errors'); 
    ?>
    <?php if (is_array($errors) && !empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 0.85rem; background-color: #fef2f2; border-left: 4px solid #ef4444 !important;">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-x-circle-fill text-danger fs-5 me-2 flex-shrink-0"></i>
                <strong class="text-danger">Lütfen aşağıdaki hataları düzeltin:</strong>
            </div>
            <ul class="mb-0 ps-4 text-danger small">
                <?php foreach ($errors as $field => $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
        </div>
    <?php elseif (is_string($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm border-0 mb-4" role="alert" style="border-radius: 0.85rem; background-color: #fef2f2; border-left: 4px solid #ef4444 !important;">
            <i class="bi bi-x-circle-fill text-danger fs-5 me-3 flex-shrink-0"></i>
            <div class="text-danger fw-medium">
                <?= esc($errors) ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Bilgi Bildirimi (Info Alert) -->
<?php if (session()->has('info') || session()->has('bilgi')): ?>
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center shadow-sm border-0 mb-4" role="alert" style="border-radius: 0.85rem; background-color: #eff6ff; border-left: 4px solid #3b82f6 !important;">
        <i class="bi bi-info-circle-fill text-primary fs-5 me-3 flex-shrink-0"></i>
        <div class="text-primary fw-medium">
            <?= esc(session('info') ?? session('bilgi')) ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
<?php endif; ?>

<!-- Uyarı Bildirimi (Warning Alert) -->
<?php if (session()->has('warning') || session()->has('uyari')): ?>
    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center shadow-sm border-0 mb-4" role="alert" style="border-radius: 0.85rem; background-color: #fffbeb; border-left: 4px solid #f59e0b !important;">
        <i class="bi bi-exclamation-circle-fill text-warning fs-5 me-3 flex-shrink-0"></i>
        <div class="text-dark fw-medium">
            <?= esc(session('warning') ?? session('uyari')) ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
<?php endif; ?>
