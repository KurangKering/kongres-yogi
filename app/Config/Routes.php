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


$routes->get('/backend', 'Backend\DashboardController::index');

$routes->get('backend/event-simposium', 'Backend\EventSimposiumController::index');
$routes->get('backend/event-simposium/json-event-simposium', 'Backend\EventSimposiumController::jsonEventSimposium');
$routes->get('backend/event-simposium/tambah', 'Backend\EventSimposiumController::tambah');
$routes->get('backend/event-simposium/detail/(:num)', 'Backend\EventSimposiumController::detail');

$routes->get('backend/simposium', 'Backend\SimposiumController::index');
$routes->get('backend/simposium/json-dt', 'Backend\SimposiumController::jsonDT');

$routes->get('backend/workshop', 'Backend\WorkshopController::index');
$routes->get('backend/workshop/json-dt', 'Backend\WorkshopController::jsonDT');

$routes->get('backend/pendaftaran', 'Backend\PendaftaranController::index');
$routes->get('backend/pendaftaran/json-pendaftaran', 'Backend\PendaftaranController::jsonPendaftaran');
$routes->get('backend/pendaftaran/detail/(:num)', 'Backend\PendaftaranController::detail/$1');

$routes->get('backend/validasi', 'Backend\ValidasiController::index');
$routes->get('backend/validasi/json-validasi-sudah-bayar', 'Backend\ValidasiController::jsonValidasiSudahBayar');
$routes->post('backend/validasi/validasi', 'Backend\ValidasiController::validasi');
$routes->get('backend/validasi/detail/(:num)', 'Backend\ValidasiController::detail/$1');
$routes->get('backend/validasi/render-verifikasi/(:num)', 'Backend\ValidasiController::renderVerifikasi/$1');


$routes->get('/', 'Frontend\HomeController::index');
$routes->get('/daftar', 'Frontend\DaftarController::index');
$routes->post('/daftar', 'Frontend\DaftarController::index');
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
