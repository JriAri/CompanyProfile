<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');


$routes->group('konsultasi', function($routes) {
    $routes->get('/', 'Konsultasi::index');
    $routes->post('kirim', 'Konsultasi::kirim');
    $routes->get('riwayat', 'Konsultasi::riwayat');
    $routes->get('tracking', 'Konsultasi::tracking');
});

$routes->get('/artikel', 'ArtikelController::index');
$routes->get('/artikel/search', 'ArtikelController::search');
$routes->get('/artikel/kategori/(:segment)', 'ArtikelController::kategori/$1');
$routes->get('/artikel/(:segment)', 'ArtikelController::detail/$1');
$routes->get('/artikel/index/(:segment)', 'ArtikelController::index/$1');
$routes->post('artikel/post-komentar', 'ArtikelController::postKomentar');

$routes->get('/penyuluh', 'Penyuluh::index');
$routes->get('penyuluh/detail/(:num)', 'Penyuluh::detail/$1');
$routes->get('penyuluh/whatsapp/(:num)', 'Penyuluh::whatsapp/$1');

$routes->get('/galeri', 'Galeri::index');
$routes->get('/belanja', 'Belanja::index');
$routes->get('/diskusi', 'Diskusi::index');
$routes->get('/tentang', 'Tentang::index');
$routes->get('/kontak', 'Kontak::index');
$routes->get('/privacy', 'Privacy::index');
$routes->get('/terms', 'Terms::index');

$routes->group('admin', function($routes) {
    $routes->get('login', 'Admin\AuthAdminController::login');
    $routes->post('login', 'Admin\AuthAdminController::attemptLogin');
    $routes->get('logout', 'Admin\AuthAdminController::logout');

    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('artikel', 'Admin\Artikel::index');
    $routes->get('artikel/create', 'Admin\Artikel::create');
    $routes->post('artikel/store', 'Admin\Artikel::store');
    $routes->get('artikel/edit/(:num)', 'Admin\Artikel::edit/$1');
    $routes->put('artikel/update/(:num)', 'Admin\Artikel::update/$1');
    $routes->delete('artikel/delete/(:num)', 'Admin\Artikel::delete/$1');

    $routes->get('konsultasi', 'Admin\Konsultasi::index');
    $routes->get('konsultasi/detail/(:num)', 'Admin\Konsultasi::detail/$1');
    $routes->post('konsultasi/jawab/(:num)', 'Admin\Konsultasi::jawab/$1');
    $routes->post('konsultasi/updateStatus/(:num)', 'Admin\Konsultasi::updateStatus/$1');
    $routes->delete('konsultasi/(:num)', 'Admin\Konsultasi::delete/$1');

    $routes->post('admin/penyuluh/checkEmail', 'Admin\Penyuluh::checkEmail');
    $routes->post('admin/penyuluh/checkPhone', 'Admin\Penyuluh::checkPhone');
    $routes->post('admin/penyuluh/checkWilayah', 'Admin\Penyuluh::checkWilayah');

    $routes->get('penyuluh', 'Admin\Penyuluh::index');
    $routes->get('penyuluh/tambah', 'Admin\Penyuluh::tambah');
    $routes->post('penyuluh/simpan', 'Admin\Penyuluh::simpan');
    $routes->get('penyuluh/edit/(:num)', 'Admin\Penyuluh::edit/$1');
    $routes->post('penyuluh/update/(:num)', 'Admin\Penyuluh::update/$1');
    $routes->post('penyuluh/hapus/(:num)', 'Admin\Penyuluh::hapus/$1');

    $routes->get('galeri', 'Admin\Galeri::index');
    $routes->get('galeri/tambah', 'Admin\Galeri::tambah');
    $routes->post('galeri/simpan', 'Admin\Galeri::simpan');
    $routes->get('galeri/edit/(:num)', 'Admin\Galeri::edit/$1');
    $routes->post('galeri/update/(:num)', 'Admin\Galeri::update/$1');
    $routes->delete('galeri/(:num)', 'Admin\Galeri::hapus/$1');

    $routes->get('belanja', 'Admin\Belanja::index');
    $routes->get('belanja/tambah', 'Admin\Belanja::tambah');
    $routes->post('belanja/simpan', 'Admin\Belanja::simpan');
    $routes->get('belanja/edit/(:num)', 'Admin\Belanja::edit/$1');
    $routes->put('belanja/(:num)', 'Admin\Belanja::update/$1');
    $routes->delete('belanja/(:num)', 'Admin\Belanja::hapus/$1');
});
