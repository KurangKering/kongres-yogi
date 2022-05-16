<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/show-file/bukti-pembayaran/(:any)', 'ImageController::buktiPembayaran/$1');

$routes->get('login', 'Backend\AuthController::login');
$routes->get('logout', 'Backend\AuthController::logout');
$routes->post('login', 'Backend\AuthController::login');


$routes->get('/backend', 'Backend\DashboardController::index', ['filter' => 'auth']);

$routes->get('backend/hotel', 'Backend\HotelController::index', ['filter' => 'auth']);
$routes->get('backend/hotel/json-hotel', 'Backend\HotelController::jsonHotel', ['filter' => 'auth']);

$routes->get('backend/event', 'Backend\EventController::index', ['filter' => 'auth']);
$routes->get('backend/event/json-event', 'Backend\EventController::jsonEvent', ['filter' => 'auth']);

$routes->get('backend/event-simposium', 'Backend\EventSimposiumController::index', ['filter' => 'auth']);
$routes->get('backend/event-simposium/json-event-simposium', 'Backend\EventSimposiumController::jsonEventSimposium', ['filter' => 'auth']);
$routes->get('backend/event-simposium/tambah', 'Backend\EventSimposiumController::tambah', ['filter' => 'auth']);
$routes->get('backend/event-simposium/detail/(:num)', 'Backend\EventSimposiumController::detail', ['filter' => 'auth']);

$routes->get('backend/simposium', 'Backend\SimposiumController::index', ['filter' => 'auth']);
$routes->get('backend/simposium/json-simposium', 'Backend\SimposiumController::jsonSimposium', ['filter' => 'auth']);


$routes->get('backend/workshop', 'Backend\WorkshopController::index', ['filter' => 'auth']);
$routes->get('backend/workshop/json-workshop', 'Backend\WorkshopController::jsonWorkshop', ['filter' => 'auth']);

$routes->get('backend/pendaftaran', 'Backend\PendaftaranController::index', ['filter' => 'auth']);
$routes->get('backend/pendaftaran/json-pendaftaran', 'Backend\PendaftaranController::jsonPendaftaran', ['filter' => 'auth']);
$routes->get('backend/pendaftaran/detail/(:num)', 'Backend\PendaftaranController::detail/$1', ['filter' => 'auth']);

$routes->get('backend/validasi', 'Backend\ValidasiController::index', ['filter' => 'auth']);
$routes->get('backend/validasi/json/(:any)', 'Backend\ValidasiController::json/$1', ['filter' => 'auth']);


$routes->post('backend/validasi/validasi', 'Backend\ValidasiController::validasi', ['filter' => 'auth']);
$routes->get('backend/validasi/detail/(:num)', 'Backend\ValidasiController::detail/$1', ['filter' => 'auth']);
$routes->get('backend/validasi/modal-validasi/(:num)', 'Backend\ValidasiController::modalValidasi/$1', ['filter' => 'auth']);
$routes->post('backend/validasi/send-mail/(:any)', 'Backend\ValidasiController::sendMail/$1', ['filter' => 'auth']);



$routes->get('backend/verifikasi', 'Backend\VerifikasiController::index', ['filter' => 'auth']);
$routes->get('backend/verifikasi/json-verifikasi', 'Backend\VerifikasiController::jsonVerifikasi', ['filter' => 'auth']);
$routes->get('backend/verifikasi/detail/(:num)', 'Backend\VerifikasiController::detail/$1', ['filter' => 'auth']);

$routes->get('backend/email', 'Backend\EmailController::index', ['filter' => 'auth']);
$routes->post('backend/email', 'Backend\EmailController::index', ['filter' => 'auth']);


$routes->get('/', 'Frontend\HomeController::index');
$routes->get('/daftar', 'Frontend\DaftarController::index');
$routes->post('/daftar', 'Frontend\DaftarController::index');
$routes->get('/daftar/lookup-jenis-kamar', 'Frontend\DaftarController::lookupJenisKamar');
$routes->get('/daftar/lookup-tanggal-menginap', 'Frontend\DaftarController::lookupTanggalMenginap');
$routes->get('/daftar/lookup-lama-menginap', 'Frontend\DaftarController::lookupLamaMenginap');

$routes->get('/validasi-pembayaran', 'Frontend\ValidasiPembayaranController::index');
$routes->post('/validasi-pembayaran', 'Frontend\ValidasiPembayaranController::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
