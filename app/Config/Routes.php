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
$routes->addRedirect('/', 'ecm');

$routes->group('ecm', static function ($routes) {
    $routes->get('/', 'Home::index', ['as' => 'home']);
    
    $routes->get('websites', 'Websites::index', ['as' => 'website.index']);
    $routes->match(['get', 'post'],'websites/add', 'Websites::add', ['as' => 'website.add']);
    $routes->get('websites/show/(:num)', 'Websites::show/$1', ['as' => 'website.show']);
    $routes->match(['get', 'post'],'websites/edit/(:num)', 'Websites::edit/$1', ['as' => 'website.edit']);

    $routes->get('invoices', 'Invoices::index', ['as' => 'invoice.index']);
    $routes->match(['get', 'post'],'invoices/add', 'Invoices::add', ['as' => 'invoice.add']);
    $routes->get('invoices/show/(:num)', 'Invoices::show/$1', ['as' => 'invoice.show']);
    $routes->match(['get', 'post'],'invoices/edit/(:num)', 'Invoices::edit/$1', ['as' => 'invoice.edit']);

    $routes->get('customers', 'Customers::index', ['as' => 'customer.index']);
    $routes->match(['get', 'post'],'customers/add', 'Customers::add', ['as' => 'customer.add']);
    $routes->get('customers/show/(:num)', 'Customers::show/$1', ['as' => 'customer.show']);
    $routes->match(['get', 'post'],'customers/edit/(:num)', 'Customers::edit/$1', ['as' => 'customer.edit']);


    $routes->get('projects', 'Projects::index', ['as' => 'project.index']);
    $routes->match(['get', 'post'],'projects/add', 'Projects::add', ['as' => 'project.add']);
    $routes->match(['get', 'post'],'projects/edit/(:num)', 'Projects::edit/$1', ['as' => 'project.edit']);
    $routes->get('projects/show/(:num)', 'Projects::show/$1', ['as' => 'project.show']);

    $routes->match(['get', 'post'],'comments/add', 'Comments::add', ['as' => 'comment.add']);
    $routes->match(['get', 'post'],'comments/edit/(:num)', 'Comments::edit/$1', ['as' => 'comment.edit']);

    $routes->get('tags', 'TagsController::index', ['as' => 'tag.index']);
    $routes->match(['get', 'post'],'tags/add', 'TagsController::add', ['as' => 'tag.add']);
    $routes->match(['get', 'post'],'tags/edit/(:num)', 'TagsController::edit/$1', ['as' => 'tag.edit']);
    
});

$routes->group('admin', static function ($routes) {

    $routes->match(['get', 'post'],'settings', 'Settings::index', ['as' => 'admin.settings', 'filter' => 'permission:admin.settings']);

    $routes->match(['get', 'post'],'users', 'UserController::index', ['as' => 'user.index', 'filter' => 'permission:user.show']);
    $routes->match(['get', 'post'],'users/add', 'UserController::add', ['as' => 'user.add', 'filter' => 'permission:user.add']);
    $routes->match(['get', 'post'],'users/edit/(:num)', 'UserController::edit/$1', ['as' => 'user.edit', 'filter' => 'permission:user.edit']);

});




$routes->cli('cron', 'Invoices::cron');
$routes->get('cron', 'Invoices::cron');

$routes->group('api/0', static function ($routes) {
    $routes->delete('website/delete/(:num)', 'Websites::apiDelete/$1');
    $routes->get('websites', 'apiWebsitesController::getWebsites');


    $routes->delete('customer/delete/(:num)', 'Customers::apiDelete/$1');

    $routes->delete('project/delete/(:num)', 'Projects::apiDelete/$1');
    $routes->get('projects', 'apiProjectsController::getProjects');

    $routes->delete('invoice/delete/(:num)', 'Invoices::apiDelete/$1');

    $routes->delete('comment/delete/(:num)', 'Comments::apiDelete/$1');

    $routes->delete('tag/delete/(:num)', 'TagsController::apiDelete/$1');
    
    $routes->delete('user/delete/(:num)', 'UserController::apiDelete/$1', ['filter' => 'permission:user.delete']);

    $routes->get('profile/createToken/', 'apiProfileController::createToken');
    $routes->get('profile/deleteToken/', 'apiProfileController::deleteToken');

});

$routes->group('api/v1', static function ($routes) {
    
    $routes->get('websites', 'apiWebsitesController::getWebsites');

    $routes->get('projects', 'apiProjectsController::getProjects');

});



service('auth')->routes($routes);

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