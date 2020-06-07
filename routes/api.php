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

Router::get('/api/patients/all', "Patients\ApiController@getAll", User::ROLE_ADMIN);

Router::post('/api/patients/adding', "Patients\ApiController@adding", User::ROLE_ADMIN);
Router::post('/api/patients/updating', "Patients\ApiController@updating", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visits
 * ---------------------------------------------------------------------------------------
 */

Router::post('/api/visits/adding', "Visits\ApiController@adding", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for symptoms
 * ---------------------------------------------------------------------------------------
 */
Router::get('/api/symptoms/all', "Symptoms\ApiController@getAll", User::ROLE_ADMIN);

Router::post('/api/symptoms/adding', "Symptoms\ApiController@adding", User::ROLE_ADMIN);
