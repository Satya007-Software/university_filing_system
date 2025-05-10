<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//----------------------------------------------------------
// Authentication Routes
//----------------------------------------------------------
$routes->get('/signup', 'Signup::index');
$routes->post('/signup/process', 'Signup::process');
$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::process');
$routes->get('/logout', 'Login::logout');

//----------------------------------------------------------
// Dashboard & Profile Routes
//----------------------------------------------------------
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/profile', 'Dashboard::profile');
$routes->get('/dashboard/addUser', 'Dashboard::addUser');
$routes->post('/dashboard/processAddUser', 'Dashboard::processAddUser');
$routes->get('user/documents/(:num)', 'Dashboard::userDocuments/$1');
$routes->get('/dashboard/notifications', 'Dashboard::notifications');
$routes->post('/profile/updateProfile', 'Profile::update');


//----------------------------------------------------------
// User Management Routes
//----------------------------------------------------------
$routes->post('dashboard/resetUserPassword/(:num)', 'Dashboard::resetUserPassword/$1');
$routes->post('dashboard/removeUser/(:num)', 'Dashboard::removeUser/$1');

//----------------------------------------------------------
// Document & Upload Routes
//----------------------------------------------------------
$routes->get('/upload', 'Upload::index');
$routes->post('/upload/process', 'Upload::process');
$routes->get('/document/share/(:num)', 'Share::index/$1');
$routes->post('/document/share/(:num)/process', 'Share::process/$1');
$routes->get('dashboard/archive/(:num)', 'Dashboard::archive/$1');
$routes->get('dashboard/delete/(:num)', 'Dashboard::delete/$1');
$routes->post('dashboard/reviewDocument/(:num)', 'Dashboard::reviewDocument/$1');


//----------------------------------------------------------
// Document Review & Approval Routes
//----------------------------------------------------------
$routes->get('/approval/request/(:num)', 'Approval::request/$1');
$routes->post('/approval/processRequest', 'Approval::processRequest');
$routes->get('/approval/approve/(:num)', 'Approval::approve/$1');
$routes->get('/approval/reject/(:num)', 'Approval::reject/$1');
$routes->get('/approval/sendBack/(:num)', 'Approval::sendBack/$1');
$routes->get('upload', 'uploadForm'); // Assuming a method to display upload form
$routes->get('documents', 'myDocuments'); // Assuming a method to display user's documents
$routes->get('shared', 'sharedWithMe'); // Assuming a method to display shared documents
$routes->get('users', 'index');         // Display list of users
$routes->get('reports', 'index');       // Display reports
$routes->get('profile', 'index');     // Display user profile
$routes->get('settings', 'index');   // Display settings
