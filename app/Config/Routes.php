<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['as' => 'home']);

$routes->get('/websites', 'Websites::index', ['as' => 'website.index', 'filter' => 'Auth']);
$routes->match(['get', 'post'],'/websites/add', 'Websites::add', ['as' => 'website.add', 'filter' => 'Auth']);
$routes->get('/websites/show/(:num)', 'Websites::show/$1', ['as' => 'website.show', 'filter' => 'Auth']);
$routes->match(['get', 'post'],'/websites/edit/(:num)', 'Websites::edit/$1', ['as' => 'website.edit', 'filter' => 'Auth']);

$routes->get('/invoices', 'Invoices::index', ['as' => 'invoice.index', 'filter' => 'Auth']);
$routes->match(['get', 'post'],'/invoices/add', 'Invoices::add', ['as' => 'invoice.add', 'filter' => 'Auth']);

$routes->get('/customers', 'Customers::index', ['as' => 'customer.index', 'filter' => 'Auth']);

$routes->get('/orders', 'Orders::index', ['as' => 'order.index', 'filter' => 'Auth']);




$routes->cli('invoice', 'Cron::invoice');


$routes->delete('/api/website/delete/(:num)', 'Websites::apiDelete/$1');


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
