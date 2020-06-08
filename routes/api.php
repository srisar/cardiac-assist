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

Router::get('/api/patients/all', "Patients\Api@getAll", User::ROLE_ADMIN);

Router::post('/api/patients/adding', "Patients\Api@adding", User::ROLE_ADMIN);
Router::post('/api/patients/updating', "Patients\Api@updating", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visits
 * ---------------------------------------------------------------------------------------
 */

Router::post('/api/visits/adding', "Visits\Api@adding", User::ROLE_ADMIN);
Router::post('/api/visits/updating', "Visits\Api@updating", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for symptoms
 * ---------------------------------------------------------------------------------------
 */
Router::get('/api/symptoms/all', "Symptoms\Api@getAll", User::ROLE_ADMIN);
Router::get('/api/symptoms/auto-complete', "Symptoms\Api@autoCompleteResponse", User::ROLE_ADMIN);
Router::get('/api/symptoms/find', "Symptoms\Api@find", User::ROLE_ADMIN);

Router::post('/api/symptoms/adding', "Symptoms\Api@adding", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visit-symptoms
 * ---------------------------------------------------------------------------------------
 */
Router::post('/api/visits/symptoms/adding', "VisitSymptoms\Api@adding", User::ROLE_ADMIN);