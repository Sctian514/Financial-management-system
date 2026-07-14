<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// -------------------- Halaman Login dan Registrasi -------------------- //
$routes->get('/', 'Auth::login');


$routes->get('auth/lupa_password', 'Auth::lupa_password');
$routes->post('auth/proses_lupa_password', 'Auth::proses_lupa_password');
$routes->get('auth/reset_password/(:any)', 'Auth::reset_password/$1');
$routes->post('auth/update_reset_password', 'Auth::update_reset_password');




// Semua route di bawah ini membutuhkan filter 'auth' untuk akses
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // -------------------- Register -------------------- //
    $routes->get('register_view', 'Auth::register');

    // -------------------- Dashboard dan Profil -------------------- //
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'UserController::profile');

    // -------------------- Bagian Anggaran -------------------- //
    $routes->get('anggaran', 'AnggaranController::index');
    $routes->match(['get', 'post'], 'anggaran/search', 'AnggaranController::search', ['as' => 'anggaran.search']);
    $routes->get('anggaran/create', 'AnggaranController::create', ['as' => 'anggaran.create']);
    $routes->post('anggaran/store', 'AnggaranController::store', ['as' => 'anggaran.store']);
    $routes->post('anggaran/update', 'AnggaranController::update', ['as' => 'anggaran.update']);
    $routes->get('anggaran/edit/(:num)', 'AnggaranController::edit/$1', ['as' => 'anggaran.edit']);
    $routes->get('anggaran/delete/(:num)', 'AnggaranController::delete/$1', ['as' => 'anggaran.delete']);

    // -------------------- Bagian Kegiatan -------------------- //
    $routes->match(['get', 'post'], 'kegiatan/search/(:num)', 'KegiatanController::search/$1', ['as' => 'kegiatan.search']);
    $routes->get('kegiatan/create/(:num)', 'KegiatanController::create/$1', ['as' => 'kegiatan.create']);
    $routes->post('kegiatan/store', 'KegiatanController::store', ['as' => 'kegiatan.store']);
    $routes->post('kegiatan/update', 'KegiatanController::update', ['as' => 'kegiatan.update']);
    $routes->get('kegiatan/(:num)', 'KegiatanController::index/$1', ['as' => 'kegiatan.index']);
    $routes->get('kegiatan/edit/(:num)', 'KegiatanController::edit/$1', ['as' => 'kegiatan.edit']);
    $routes->get('kegiatan/delete/(:num)', 'KegiatanController::delete/$1', ['as' => 'kegiatan.delete']);

    // -------------------- Bagian Rincian -------------------- //
    $routes->get('rincian/(:num)', 'RincianController::index/$1', ['as' => 'rincian.index']);
    $routes->match(['get', 'post'], 'rincian/search/(:num)', 'RincianController::search/$1', ['as' => 'rincian.search']);
    $routes->get('rincian/create/(:num)', 'RincianController::create/$1', ['as' => 'rincian.create']);
    $routes->post('rincian/store', 'RincianController::store', ['as' => 'rincian.store']);
    $routes->get('rincian/edit/(:num)', 'RincianController::edit/$1', ['as' => 'rincian.edit']);
    $routes->post('rincian/update', 'RincianController::update', ['as' => 'rincian.update']);
    $routes->get('rincian/delete/(:num)', 'RincianController::delete/$1', ['as' => 'rincian.delete']);

    // -------------------- Logout -------------------- //
    $routes->get('auth/ganti_password', 'Auth::ganti_password');
    $routes->post('auth/update_password', 'Auth::update_password');



    $routes->get('auth/logout', 'Auth::logout');
});

// -------------------- Pengaturan Umum Routes -------------------- //
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
