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
$routes->get('/backend', 'Backend\DashboardController::index');

$routes->get('backend/data-event-simposium', 'Backend\EventSimposiumController::index');
$routes->get('backend/data-event-simposium/json-dt', 'Backend\EventSimposiumController::jsonDT');
$routes->get('backend/data-simposium', 'Backend\SimposiumController::index');
$routes->get('backend/data-simposium/json-dt', 'Backend\SimposiumController::jsonDT');
$routes->get('backend/data-workshop', 'Backend\WorkshopController::index');
$routes->get('backend/data-workshop/json-dt', 'Backend\WorkshopController::jsonDT');
$routes->get('backend/data-pendaftaran', 'Backend\PendaftaranController::index');
$routes->get('backend/data-pendaftaran/json-dt', 'Backend\PendaftaranController::jsonDT');
$routes->get('backend/data-validasi', 'Backend\ValidasiController::index');
$routes->get('backend/data-validasi/json-dt', 'Backend\ValidasiController::jsonDT');

$routes->get('login', 'Backend\AuthController::login');
$routes->get('logout', 'Backend\AuthController::logout');
$routes->post('login', 'Backend\AuthController::login');


$routes->get('/', 'Frontend\HomeController::index');
$routes->get('/daftar', 'Frontend\HomeController::daftar');
$routes->post('/daftar', 'Frontend\HomeController::daftar');


$routes->get('/validasi-pembayaran', 'Frontend\HomeController::validasiPembayaran');
$routes->post('/validasi-pembayaran', 'Frontend\HomeController::validasiPembayaran');

$routes->get('/show-file/bukti-pembayaran/(:any)', 'ImageController::buktiPembayaran/$1');


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
