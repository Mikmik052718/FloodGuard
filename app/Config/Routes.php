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
$routes->get('/forum/loadMorePosts', 'Forum::loadMorePosts');

//regis handle
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::handleRegister');


$routes->get('/auth/adlogin', 'Auth::adlogin');                                 //admin login
$routes->get('/auth/uslogin', 'Auth::uslogin');                                 //user login

$routes->post('/auth/attemptLogin', 'Auth::attemptLogin');
$routes->post('/auth/updateProfile', 'Auth::updateProfile');
$routes->get('/auth/logout', 'Auth::logout');

// Google OAuth routes
$routes->get('/auth/google', 'Auth::googleLogin');
$routes->get('/auth/google/callback', 'Auth::googleCallback');



//admin actv
$routes->get('/admin/posts', 'Admin::posts');
$routes->get('/admin/delete/(:num)', 'Admin::delete/$1');
//user edit
$routes->get('forum/edit/(:num)', 'Forum::edit/$1');
$routes->post('forum/update/(:num)', 'Forum::update/$1');
$routes->get('forum/delete/(:num)', 'Forum::delete/$1');
//admin edit
$routes->get('admin/edit/(:num)', 'Admin::edit/$1');
$routes->post('admin/update/(:num)', 'Admin::update/$1');

// open meteo 
$routes->get('/weather', 'Forum::weather');
$routes->get('/weather-daily', 'Forum::weatherDaily');


$routes->get('flood/predict_hourly', 'FloodPredictor::predict_hourly'); // hourly  08/24/25 18:30


//new sto nino info
$routes->get('flood/river-status', 'FloodPredictor::riverStatus');

$routes->get('/home', 'Home::index');
$routes->get('/home/weather-data', 'Home::getWeatherData');
                                                                                    //Landing - for the url
                                                                                    //Home - to fetch the controller
                                                                                    //index - to find the method


// Admin routes
$routes->get('/admin/admin_dashboard', 'Admin::dashboard');
$routes->get('/admin/users', 'Admin::users');
$routes->get('/admin/force-post', 'Admin::forcePost');

//09/09/25
$routes->get('emailtest', 'Email_cont::index');

$routes->get('emailtest', 'Email_cont::index');        // single test
$routes->get('send-emails', 'Email_cont::sendToUsers'); // send to users

$routes->get('email', 'Email_cont::form');        // show form
$routes->post('email/send', 'Email_cont::sendEmail'); // process form
$routes->get('/landing', 'Landingpagecontroller::landing'); //landing

//091325 DAILY
$routes->get('flood/daily', 'FloodPredictor::index');
$routes->get('flood/predict-ajax', 'FloodPredictor::predictAjax');
$routes->get('flood/hazard-maps', 'FloodPredictor::hazardMaps');

$routes->get('flood/hourly', 'FloodPredictor::hourly');
$routes->get('flood/hourly/data', 'FloodPredictor::predict_hourly_ajax');

// User location routes
$routes->post('flood/save-location', 'FloodPredictor::saveUserLocation');
$routes->get('flood/get-location', 'FloodPredictor::getUserLocation');

// CLI route for autopost
$routes->cli('autopost', 'AutoPost::index');

// Water alerts
$routes->get('email/water-alerts', 'Email_cont::sendWaterAlerts');
$routes->post('email/send-water-alert', 'Email_cont::sendWaterAlertManual');

// SMS routes
$routes->get('sms', 'SmsController::index');
$routes->post('sms/send-water-alert', 'SmsController::sendWaterAlertManual');
$routes->get('sms/water-alerts', 'SmsController::sendWaterAlertsSMS'); // sms water alerts
$routes->match(['get', 'post'], 'sms/gateway', 'SmsController::gateway');

