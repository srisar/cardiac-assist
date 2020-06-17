<?php

use App\Core\Router;
use App\Models\User;


/**
 * NOTE: make sure to change admin access to ROLE_ADMIN when deploy
 */
define('ADMIN_ACCESS', User::ROLE_NONE);


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
Router::post('/api/auth/login', "System\AuthController@apiProcessLogin", User::ROLE_NONE);
Router::post('/api/users/add', "System\Users\Api@add", ADMIN_ACCESS);
Router::post('/api/users/edit', "System\Users\Api@edit", ADMIN_ACCESS);

Router::get('/api/users/all', "System\Users\Api@getAll", User::ROLE_ADMIN);


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

Router::get('/api/visit/find', "Visits\Api@find", User::ROLE_ADMIN);
Router::post('/api/visit/add', "Visits\Api@add", User::ROLE_ADMIN);
Router::post('/api/visit/update', "Visits\Api@update", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for symptoms
 * ---------------------------------------------------------------------------------------
 */
Router::get('/api/symptom/all', "Symptoms\Api@getAll", User::ROLE_ADMIN);
Router::get('/api/symptom/search', "Symptoms\Api@search", User::ROLE_ADMIN);
Router::get('/api/symptom/find', "Symptoms\Api@find", User::ROLE_ADMIN);

Router::post('/api/symptom/add', "Symptoms\Api@add", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visit-symptoms
 * ---------------------------------------------------------------------------------------
 */
Router::get('/api/visit-symptom/by-visit', "VisitSymptoms\Api@getAllByVisit", ADMIN_ACCESS);
Router::get('/api/visit-symptom/find', "VisitSymptoms\Api@findById", User::ROLE_ADMIN);

Router::post('/api/visit-symptom/add', "VisitSymptoms\Api@add", User::ROLE_ADMIN);
Router::post('/api/visit-symptom/delete', "VisitSymptoms\Api@delete", User::ROLE_ADMIN);