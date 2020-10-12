<?php

use App\Core\Router;
use App\Models\User;

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for the web based views
 * ---------------------------------------------------------------------------------------
 */

Router::get("/", "PagesController@index");
Router::get("/test", "System\TestController@genericTest");


/*
 * ---------------------------------------------------------------------------------------
 * | Routes for auth system
 * ---------------------------------------------------------------------------------------
 */

Router::get('/login', "System\AuthController@viewLogin");
Router::get('/logout', 'System\AuthController@processLogout');
Router::post('/auth/process-login', 'System\AuthController@processLogin');

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for user management
 * ---------------------------------------------------------------------------------------
 */
Router::get('/users', "System\Users\Web@viewUsers", User::ROLE_ADMIN);
Router::get('/users/add', "System\Users\Web@viewAddUser", User::ROLE_ADMIN);
Router::get('/users/edit', "System\Users\Web@viewEditUser", User::ROLE_ADMIN);

Router::post('/users/process-add', "System\UsersController@processAddUser", User::ROLE_ADMIN);
Router::post('/users/process-edit', "System\UsersController@processEditUser", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for patients
 * ---------------------------------------------------------------------------------------
 */

Router::get('/patients/add', "Patients\Web@viewAdd", User::ROLE_ADMIN);
Router::get('/patients', "Patients\Web@viewAll", User::ROLE_ADMIN);
Router::get('/patients/edit', "Patients\Web@viewEdit", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visits
 * ---------------------------------------------------------------------------------------
 */

Router::get('/visits/add', "Visits\Web@viewAdd", User::ROLE_ADMIN);
Router::get('/visits/edit', "Visits\Web@viewEdit", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for symptoms
 * ---------------------------------------------------------------------------------------
 */

Router::get('/symptoms', "Symptoms\Web@viewManage", User::ROLE_ADMIN);

Router::get('/diseases', "Diseases\Web@manage", User::ROLE_ADMIN);