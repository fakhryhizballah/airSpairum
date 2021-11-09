<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
//$routes->setDefaultController('Home');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->get('/regis', 'Auth::regis');
$routes->post('/save', 'Auth::save');
$routes->get('/daftar', 'Auth::daftar');
$routes->get('/otp/(:any)', 'Auth::otp/$1');
$routes->get('/lupa', 'Auth::lupa');
$routes->post('/sendemail', 'Auth::sendemail');


$routes->get('/history', 'Driver::history');
$routes->get('/profil', 'Driver::index');
$routes->get('/explore', 'Driver::explore');


// $routes->get('/user', 'User::index');
$routes->get('/user', 'User::index', ['filter' => 'AuthFilter']);
$routes->get('/stasiun', 'User::stasiun', ['filter' => 'AuthFilter']);
$routes->get('/riwayat', 'User::riwayat', ['filter' => 'AuthFilter']);
$routes->get('/payriwayat', 'User::payriwayat', ['filter' => 'AuthFilter']);
$routes->get('/connect', 'User::connect', ['filter' => 'AuthFilter']);
$routes->get('/topup', 'User::topup', ['filter' => 'AuthFilter']);
$routes->post('/snap', 'User::snap', ['filter' => 'AuthFilter']);
$routes->add('/notification', 'User::notification', ['filter' => 'AuthFilter']);
$routes->get('/editprofile', 'User::editprofile', ['filter' => 'AuthFilter']);
$routes->get('/changepassword', 'User::changepassword', ['filter' => 'AuthFilter']);
$routes->get('/verifikasi/(:any)', 'User::verifikasi/$1');


$routes->get('/control', 'TransMqtt::index', ['filter' => 'AuthFilter']);

// $routes->get('/Payapi/tes', 'Payapi::tes');
$routes->get('/payapi/tes',             'Payapi::tes');
// $routes->get('/stasiun', 'User::stasiun');
// $routes->get('/riwayat', 'User::riwayat');
// $routes->get('/payriwayat', 'User::payriwayat');
// $routes->get('/connect', 'User::connect');
// $routes->get('/topup', 'User::topup');
// $routes->post('/snap', 'User::snap');
// $routes->add('/notification', 'User::notification');
// $routes->get('/editprofile', 'User::editprofile');
// $routes->get('/changepassword', 'User::changepassword');
// $routes->get('/verifikasi/(:any)', 'user::verifikasi/$1');







// $routes->addRedirect('home/history', 'history');


// $routes->addRedirect('driver/index', 'profil');
//  $routes->group('', ['filter' => 'user'], function ($routes) {
//  	$routes->get('stasiun', 'user::stasiun');
// });


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
