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

$routes->get('/websites', 'Websites::index', ['as' => 'website.index']);
$routes->match(['get', 'post'],'/websites/add', 'Websites::add', ['as' => 'website.add']);
$routes->get('/websites/show/(:num)', 'Websites::show/$1', ['as' => 'website.show']);
$routes->match(['get', 'post'],'/websites/edit/(:num)', 'Websites::edit/$1', ['as' => 'website.edit']);

$routes->get('/invoices', 'Invoices::index', ['as' => 'invoice.index']);
$routes->match(['get', 'post'],'/invoices/add', 'Invoices::add', ['as' => 'invoice.add']);
$routes->get('/invoices/show/(:num)', 'Invoices::show/$1', ['as' => 'invoice.show']);
$routes->match(['get', 'post'],'/invoices/edit/(:num)', 'Invoices::edit/$1', ['as' => 'invoice.edit']);

$routes->get('/customers', 'Customers::index', ['as' => 'customer.index']);
$routes->match(['get', 'post'],'/customers/add', 'Customers::add', ['as' => 'customer.add']);
$routes->get('/customers/show/(:num)', 'Customers::show/$1', ['as' => 'customer.show']);
$routes->match(['get', 'post'],'/customers/edit/(:num)', 'Customers::edit/$1', ['as' => 'customer.edit']);


$routes->get('/projects', 'Projects::index', ['as' => 'project.index']);
$routes->match(['get', 'post'],'/projects/add', 'Projects::add', ['as' => 'project.add']);
$routes->match(['get', 'post'],'/projects/edit/(:num)', 'Projects::edit/$1', ['as' => 'project.edit']);
$routes->get('/projects/show/(:num)', 'Projects::show/$1', ['as' => 'project.show']);

$routes->match(['get', 'post'],'/comments/add', 'Comments::add', ['as' => 'comment.add']);



$routes->cli('cron', 'Invoices::cron');
$routes->get('cron', 'Invoices::cron');


$routes->delete('/api/website/delete/(:num)', 'Websites::apiDelete/$1');
$routes->delete('/api/customer/delete/(:num)', 'Customers::apiDelete/$1');
$routes->delete('/api/project/delete/(:num)', 'Projects::apiDelete/$1');
$routes->delete('/api/invoice/delete/(:num)', 'Invoices::apiDelete/$1');


$routes->get('/admin', 'Admin::index', ['as' => 'admin.index']);



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