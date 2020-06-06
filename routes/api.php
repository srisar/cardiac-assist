<?php

use App\Core\Router;
use App\Models\User;

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for the api access
 * ---------------------------------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for user and auth
 * ---------------------------------------------------------------------------------------
 */
Router::post('/api/auth/process-login', "System\AuthController@apiProcessLogin", User::ROLE_NONE);
Router::post('/api/users/process-add', "System\UsersController@apiProcessAdduser", User::ROLE_ADMIN);


/*
 * ---------------------------------------------------------------------------------------
 * | Routes for patients
 * ---------------------------------------------------------------------------------------
 */

Router::post('/api/patients/adding', "Patients\PatientsAPIController@adding", User::ROLE_ADMIN);
Router::post('/api/patients/editing', "Patients\PatientsAPIController@editing", User::ROLE_ADMIN);
Router::get('/api/patients/all', "Patients\PatientsAPIController@getAll", User::ROLE_ADMIN);