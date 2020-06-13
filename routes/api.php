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
Router::get('/api/symptom/all', "Symptoms\Api@getAll", User::ROLE_ADMIN);
Router::get('/api/symptom/search', "Symptoms\Api@search", User::ROLE_ADMIN);
Router::get('/api/symptom/find', "Symptoms\Api@find", User::ROLE_ADMIN);

Router::post('/api/symptom/add', "Symptoms\Api@add", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visit-symptoms
 * ---------------------------------------------------------------------------------------
 */
Router::get('/api/visit-symptom/by-visit', "VisitSymptoms\Api@getAllByVisit", User::ROLE_ADMIN);
Router::get('/api/visit-symptom/find', "VisitSymptoms\Api@findById", User::ROLE_ADMIN);

Router::post('/api/visit-symptom/add', "VisitSymptoms\Api@add", User::ROLE_ADMIN);
Router::post('/api/visit-symptom/delete', "VisitSymptoms\Api@delete", User::ROLE_ADMIN);