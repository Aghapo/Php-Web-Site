<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Ana kök dizini aktif dile yönlendirir (Örn: / -> /tr)
$routes->get('/', static function () {
    return redirect()->to(service('request')->getLocale());
});

// Veritabanı Kurulum Rotaları
$routes->group('install', function ($routes) {
    $routes->get('table', 'Install::create_Table');
    $routes->get('admin', 'Install::createAdmin');
    $routes->get('demo', 'Install::createDemo');
});

// =========================================================================
// ÇOK DİLLİ ROTA GRUBU ({locale} -> 'tr' veya 'en')
// =========================================================================
$routes->group('{locale}', function ($routes) {

    // Ana Sayfa
    $routes->get('/', 'Home::index');

    // Kayıt Rotaları (Modern Register)
    $routes->get('register', 'Backend\Register::index');
    $routes->post('register', 'Backend\Register::create');

    // Giriş / Çıkış Rotaları
    $routes->get('login', 'Login::index');
    $routes->post('login/kontrol', 'Login::kontrol');
    $routes->post('logout', 'Login::cikis');

    // Öğrenci CRUD İşlemleri
    $routes->get('ogrenci/ekle', 'Merhaba::ekleSayfasi');
    $routes->post('ogrenci/ekle', 'Merhaba::kaydet');
    $routes->post('ogrenci/sil/(:num)', 'Merhaba::sil/$1');
    $routes->get('ogrenci/duzenle/(:num)', 'Merhaba::duzenle/$1');
    $routes->post('ogrenci/guncelle/(:num)', 'Merhaba::guncelle/$1');
    $routes->get('ogrenci/cop_kutusu', 'Merhaba::cop_kutusu');
    $routes->post('ogrenci/kurtar/(:num)', 'Merhaba::kurtar/$1');
    $routes->post('kalici-sil/(:num)', 'Merhaba::kalici_sil/$1');

    // Notlar CRUD İşlemleri
    $routes->get('ogrenci/(:num)/notlar', 'Notlar::index/$1');
    $routes->post('ogrenci/(:num)/notlar', 'Notlar::kaydet/$1');
    $routes->post('not/sil/(:num)', 'Notlar::sil/$1');

    // Dersler CRUD İşlemleri
    $routes->get('dersler', 'Dersler::index');
    $routes->post('ders/kaydet', 'Dersler::kaydet');
    $routes->post('ders/sil/(:num)', 'Dersler::sil/$1');

    // Excel Aktarımı
    $routes->get('excel-aktar', 'Merhaba::excelAktar');
});

// Dil öneki olmadan erişim desteği
$routes->get('register', 'Backend\Register::index');
$routes->post('register', 'Backend\Register::create');
$routes->get('login', 'Login::index');
$routes->post('login/kontrol', 'Login::kontrol');