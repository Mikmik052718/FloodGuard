<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// URL http://localhost/FloodGuard/public/index.php/forum

$routes->get('/', 'Hello::index');  // This replaces the default Welcome controller
$routes->get('/forum', 'Forum::index');
$routes->get('/forum/create', 'Forum::create');
$routes->post('/forum/store', 'Forum::store');

//regis handle
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::handleRegister');


$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/attemptLogin', 'Auth::attemptLogin');
$routes->get('/auth/logout', 'Auth::logout');

// old $routes->get('/admin/posts', 'Forum::adminPosts'); 

//admin actv
$routes->get('/admin/posts', 'Admin::posts');
$routes->get('/admin/delete/(:num)', 'Forum::delete/$1');
//user edit
$routes->get('forum/edit/(:num)', 'Forum::edit/$1');
$routes->post('forum/update/(:num)', 'Forum::update/$1');
//admin edit
$routes->get('admin/edit/(:num)', 'Admin::edit/$1');
$routes->post('admin/update/(:num)', 'Admin::update/$1');
// open meteo 
$routes->get('/weather', 'Forum::weather');
$routes->get('/weather-daily', 'Forum::weatherDaily');
//predictor
$routes->get('flood/predict', 'FloodPredictor::predict');

//new sto nino info
$routes->get('flood/river-status', 'FloodPredictor::riverStatus');



//http://localhost/FloodGuard/public/index.php/flood/predict