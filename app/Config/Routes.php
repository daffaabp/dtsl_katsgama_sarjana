<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth::login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.



// Auth
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login_post');
$routes->get('/logout', 'Auth::logout');
$routes->get('/forgot', 'Auth::forgot_password');
$routes->post('/forgot', 'Auth::forgot_password_post');



// Public Routes
$routes->group("", ["filter" => "islogged"], function ($routes) {
    $routes->get('/alumni', 'Alumni::index');
    $routes->get('/alumni/detail/(:num)', 'Alumni::detail/$1');
    $routes->get('/alumni/info/(:num)', 'Alumni::info/$1');
});


// Program Sarjana
$routes->group("", ["filter" => "adminangkatan"], function ($routes) {
    $routes->get('/program_sarjana', 'ProgramSarjana::index');
    $routes->get('/program_sarjana/add', 'ProgramSarjana::add');
    $routes->post('/program_sarjana/add', 'ProgramSarjana::add_post');
    $routes->get('/program_sarjana/edit/(:num)', 'ProgramSarjana::edit/$1');
    $routes->post('/program_sarjana/edit/(:num)', 'ProgramSarjana::edit_post/$1');
    $routes->get('/program_sarjana/delete/(:num)', 'ProgramSarjana::delete/$1');
    $routes->get('/program_sarjana/detail/(:num)', 'ProgramSarjana::detail/$1');
    $routes->post('/program_sarjana/edit_avatar', 'ProgramSarjana::edit_avatar');
});

// Pengguna
$routes->group("", ["filter" => "adminangkatan"], function ($routes) {
    $routes->get('/pengguna', 'Pengguna::index');
    $routes->get('/pengguna/add', 'Pengguna::add');
    $routes->post('/pengguna/add', 'Pengguna::add_post');
    $routes->get('/pengguna/edit/(:num)', 'Pengguna::edit/$1');
    $routes->post('/pengguna/edit/(:num)', 'Pengguna::edit_post/$1');
    $routes->get('/pengguna/delete/(:num)', 'Pengguna::delete/$1');
});

// Mapping Pengguna
$routes->group("", ["filter" => "adminangkatan"], function ($routes) {
    $routes->get('/pengguna/mapping/(:num)', 'MappingPengguna::pengguna/$1');
    $routes->get('/pengguna/delete_mapping', 'MappingPengguna::delete_mapping');
    $routes->get('/pengguna/add_mapping', 'MappingPengguna::add_mapping');
});

// Export Data
$routes->group("", ["filter" => "adminangkatan"], function ($routes) {
    $routes->get('/export', 'ExportData::excel');
});



// User Menu
$routes->group("", ["filter" => "islogged"], function ($routes) {
    $routes->get('/profile', 'User::profile');
    $routes->post('/profile', 'User::profile_post');
    $routes->get('/change_password', 'ChangePassword::index');
    $routes->post('/change_password', 'ChangePassword::edit_post');
});


// Master Propinsi
$routes->group("", ["filter" => "superadmin"], function ($routes) {
    $routes->get('/propinsi', 'Propinsi::index');
    $routes->get('/propinsi/add', 'Propinsi::add');
    $routes->post('/propinsi/add', 'Propinsi::add_post');
    $routes->get('/propinsi/edit/(:num)', 'Propinsi::edit/$1');
    $routes->post('/propinsi/edit/(:num)', 'Propinsi::edit_post/$1');
    $routes->get('/propinsi/delete/(:num)', 'Propinsi::delete/$1');
});

// Master Bidang Kerja
$routes->group("", ["filter" => "superadmin"], function ($routes) {
    $routes->get('/bidang_kerja', 'BidangKerja::index');
    $routes->get('/bidang_kerja/add', 'BidangKerja::add');
    $routes->post('/bidang_kerja/add', 'BidangKerja::add_post');
    $routes->get('/bidang_kerja/edit/(:num)', 'BidangKerja::edit/$1');
    $routes->post('/bidang_kerja/edit/(:num)', 'BidangKerja::edit_post/$1');
    $routes->get('/bidang_kerja/delete/(:num)', 'BidangKerja::delete/$1');
});

// Master Prodi
$routes->group("", ["filter" => "superadmin"], function ($routes) {
    $routes->get('/prodi', 'Prodi::index');
    $routes->get('/prodi/add', 'Prodi::add');
    $routes->post('/prodi/add', 'Prodi::add_post');
    $routes->get('/prodi/edit/(:num)', 'Prodi::edit/$1');
    $routes->post('/prodi/edit/(:num)', 'Prodi::edit_post/$1');
    $routes->get('/prodi/delete/(:num)', 'Prodi::delete/$1');
});

// Master Role
$routes->group("", ["filter" => "superadmin"], function ($routes) {
    $routes->get('/role', 'Role::index');
    $routes->get('/role/add', 'Role::add');
    $routes->post('/role/add', 'Role::add_post');
    $routes->get('/role/edit/(:num)', 'Role::edit/$1');
    $routes->post('/role/edit/(:num)', 'Role::edit_post/$1');
    $routes->get('/role/delete/(:num)', 'Role::delete/$1');
});


// Master Angkatan
$routes->group("", ["filter" => "superadmin"], function ($routes) {
    $routes->get('/angkatan', 'Angkatan::index');
    $routes->get('/angkatan/add', 'Angkatan::add');
    $routes->post('/angkatan/add', 'Angkatan::add_post');
    $routes->get('/angkatan/edit/(:num)', 'Angkatan::edit/$1');
    $routes->post('/angkatan/edit/(:num)', 'Angkatan::edit_post/$1');
    $routes->get('/angkatan/delete/(:num)', 'Angkatan::delete/$1');
});



// Android API
$routes->get('/api/alumni', 'Api::getAlumni');
$routes->get('/api/alumni/(:num)', 'Api::getAlumniById/$1');
$routes->get('/api/filters', 'Api::getFilters');
$routes->get('/api/profile/(:num)', 'Api::getAlumniByUserId/$1');
$routes->post('/api/profile/(:num)', 'Api::editProfile/$1');

$routes->post('/api/signin', 'Api::signin');
$routes->post('/api/password', 'Api::changePassword');
$routes->post('/api/forgot', 'Api::forgotPassword');

// Android API Site
$routes->get('/api/news', 'Site::getNews');
$routes->get('/api/news/(:num)', 'Site::getNewsById/$1');

$routes->get('/api/lowongan', 'Site::getLowonganKerja');
$routes->get('/api/lowongan/(:num)', 'Site::getLowonganKerjaById/$1');

$routes->get('/api/advertisement', 'Site::getAdvertisement');
$routes->get('/api/advertisement/(:num)', 'Site::getAdvertisementById/$1');

$routes->get('/api/agenda', 'Site::getAgenda');
$routes->get('/api/agenda/(:num)', 'Site::getAgendaById/$1');

$routes->get('/api/pengurus', 'Site::getPengurus');

$routes->post('/api/avatar/(:num)', 'Api::editAvatar/$1');



// $routes->get('/builder/mapping_user_propinsi', 'Builder::mapping_user_propinsi');
// $routes->get('/builder/create_propinsi', 'Builder::create_propinsi');
// $routes->get('/builder/reset_password', 'Builder::reset_password');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
