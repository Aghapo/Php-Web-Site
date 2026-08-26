<?php

use CodeIgniter\Router\RouteCollection;

use function PHPUnit\Framework\fileExists;

/** @var RouteCollection $routes */
// $routes->get('Merhaba', 'Merhaba::index'); /Merhabada gidilecek yer

// $routes->get('/', 'Merhaba::index'); //Ana sayfa 

$routes->get('/', 'Home::index');

$routes->get('ogrenci/ekle', 'Merhaba::ekleSayfasi');//Öğrenci ekleme sayfası 
$routes->post('ogrenci/ekle', 'Merhaba::kaydet');    //Öğrenci Kaydetme

$routes->post('ogrenci/sil/(:num)' , 'Merhaba::sil/$1'); // Öğrenci Silme

$routes->get('ogrenci/duzenle/(:num)' , 'Merhaba::duzenle/$1'); //Öğrenci Düzenleme
$routes->post('ogrenci/guncelle/(:num)' , 'Merhaba::guncelle/$1');//Güncelle
$routes->get('ogrenci/(:num)/notlar', 'Notlar::index/$1');
$routes->post('ogrenci/(:num)/notlar', 'Notlar::kaydet/$1');
$routes->post('not/sil/(:num)', 'Notlar::sil/$1');

$routes ->get('ogrenci/cop_kutusu' , 'Merhaba::cop_kutusu');
$routes->post('ogrenci/kurtar/(:num)' , 'Merhaba::kurtar/$1');


//Admin sistemi için açmak gerekiyor.
// $routes->get('login', 'Login::index'); //login::index yapılırsa admin sayfası geliyor
// $routes->post('login/kontrol', 'Login::kontrol');
// $routes->post('logout', 'Login::cikis');


//Şifreleme Denemesi
// $routes->get('sifre-olustur', function() {
//     echo password_hash('123456', PASSWORD_BCRYPT);
// }); 

$routes->get('excel-aktar', 'Merhaba::excelAktar');

// Dersler CRUD Rotaları
$routes->get('dersler', 'Dersler::index');
$routes->post('ders/kaydet', 'Dersler::kaydet');
$routes->post('ders/sil/(:num)', 'Dersler::sil/$1');

$routes->post('kalici-sil/(:num)', 'Merhaba::kalici_sil/$1'); // Çöp Kutusunda Kalıcı Silme

$routes->get('ogrenci/(:num)/notlar', 'Notlar::index/$1');
$routes->post('ogrenci/(:num)/notlar', 'Notlar::kaydet/$1');
$routes->post('not/sil/(:num)', 'Notlar::sil/$1');

$routes->group('install', function ($routes) {
    $routes->get('table', 'Install::create_Table');
    $routes->get('admin', 'Install::createAdmin');
    $routes->get('demo', 'Install::createDemo');
});

$routes->get('register', 'Backend\Register::index');
$routes->post('register', 'Backend\Register::create');