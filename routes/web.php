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
Router::get('/users', "System\UsersController@viewUsers", User::ROLE_ADMIN);
Router::get('/users/add', "System\UsersController@viewAddUser", User::ROLE_ADMIN);
Router::get('/users/edit', "System\UsersController@viewEditUser", User::ROLE_ADMIN);

Router::post('/users/process-add', "System\UsersController@processAddUser", User::ROLE_ADMIN);
Router::post('/users/process-edit', "System\UsersController@processEditUser", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for patients
 * ---------------------------------------------------------------------------------------
 */

Router::get('/patients/add', "Patients\ViewsController@viewAdd", User::ROLE_ADMIN);
Router::get('/patients', "Patients\ViewsController@viewAll", User::ROLE_ADMIN);
Router::get('/patients/edit', "Patients\ViewsController@viewEdit", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for visits
 * ---------------------------------------------------------------------------------------
 */

Router::get('/visits/add', "Visits\VisitsController@viewAdd", User::ROLE_ADMIN);
Router::get('/visits/edit', "Visits\VisitsController@viewEdit", User::ROLE_ADMIN);

/*
 * ---------------------------------------------------------------------------------------
 * | Routes for symptoms
 * ---------------------------------------------------------------------------------------
 */

Router::get('/symptoms', "Symptoms\ViewsController@viewManage", User::ROLE_ADMIN);