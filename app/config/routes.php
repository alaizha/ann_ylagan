<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

// Registration is the default page
$router->match('/', 'UsersController::register', ['GET','POST']);
// Registration page as homepage
$router->match('/', 'UsersController::register', ['GET','POST']);


// Auth routes
$router->match('/auth/register', 'UsersController::register', ['GET','POST']);
$router->match('/auth/login', 'UsersController::login', ['GET','POST']);
$router->get('/auth/logout', 'UsersController::logout');

// NEW: email verification route (no token, sets verified_at)
$router->get('/auth/verify/{id}', 'UsersController::verify');

// Homepage (after login)
$router->get('/users', 'UsersController::index');
$router->get('/users/dashboard', 'UsersController::dashboard');

// ========================
// DASHBOARD ROUTES
// ========================
$router->get('/dashboard', 'Dashboard::index');
$router->get('/dashboard/patients', 'PatientsController::index');
$router->get('/dashboard/iot-devices', 'Dashboard::iot_devices');
$router->get('/dashboard/blockchain', 'Dashboard::blockchain');
$router->get('/dashboard/system-activities', 'Dashboard::system_activities');
$router->get('/dashboard/patient-details/(:num)', 'Dashboard::patient_details/$1');
$router->get('/dashboard/logout', 'Dashboard::logout');

// ========================
// PATIENTS ROUTES
$router->get('/patients', 'PatientsController::index');
$router->post('/patients/add', 'PatientsController::add');
$router->get('/patients/edit/{id}', 'PatientsController::edit');
$router->get('/patients/delete/{id}', 'PatientsController::delete');
$router->match('/patients/update/{id}', 'PatientsController::update', ['GET', 'POST']);
$router->post('/patients/exportCSV', 'PatientsController::exportCSV');

// ========================
// OTHER MODULE ROUTES
// ========================
$router->get('/analytics', 'Analytics::index');
$router->get('/settings', 'Settings::index');
$router->get('/reports', 'Reports::index');

// ========================
// BLOCKCHAIN ROUTES
// ========================
$router->get('/blockchain', 'Blockchain::index');
$router->get('/blockchain/create', 'Blockchain::create');
$router->post('/blockchain/store', 'Blockchain::store');

// ✅ EDIT Form
$router->get('/blockchain/edit/{id}', 'Blockchain::edit');

// ✅ UPDATE Form
$router->post('/blockchain/update/{id}', 'Blockchain::update');

// ✅ DELETE (ito yung nawawala, kaya nag 404)
$router->get('/blockchain/delete/{id}', 'Blockchain::delete');


// ========================
// TRANSACTIONS ROUTESs
// ========================sss
$router->get('/transactions', 'Transactions::index');
$router->post('/transactions/add', 'Transactions::add');
// ✅ PRINT RECEIPT ROUTE
$router->get('/transactions/print_receipt/{id}', 'Transactions::print_receipt');

// ========================
// IOT DEVICES ROUTES
// ========================
$router->get('/iot-devices', 'IotDevices@index');
$router->post('/iot-devices/store', 'IotDevices@store');
$router->get('/iot-devices/edit/{id}', 'IotDevices::edit');
$router->post('/iot-devices/update/{id}', 'IotDevices::update');
$router->get('/iot-devices/delete/{id}', 'IotDevices::delete');

// Appointments Routes
$router->get('/appointments', 'Appointments::index');
$router->get('/appointments/create', 'Appointments::create');
$router->post('/appointments/create', 'Appointments::create');

// remove this! (You do not have an add() method)
// $router->post('/appointments/add', 'Appointments::add');

$router->get('/appointments/edit/{id}', 'Appointments::edit');
$router->post('/appointments/edit/{id}', 'Appointments::edit');  // <-- this is correct

$router->get('/appointments/delete/{id}', 'Appointments::delete');


// User management routes (admin only)
$router->get('/users', 'UsersController::index');
$router->get('/users/edit/{id}', 'UsersController::edit');
$router->post('/users/update/{id}', 'UsersController::update');
$router->get('/users/delete/{id}', 'UsersController::delete');

// ========================
// PROFILE ROUTES - ITO ANG KULANG!
// ========================
$router->get('/profile', 'Profile::index');
$router->get('/profile/edit', 'Profile::edit');
$router->post('/profile/update', 'Profile::update');

// Medical Records Routes
$router->get('/medical-records', 'MedicalRecords::index');
