<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\User;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

try {

    $fields = [
        'username' => Request::getAsString('username'),
        'display_name' => Request::getAsString('display_name'),
        'password_string' => Request::getAsString('password_string'),
        'role' => Request::getAsString('role'),
    ];

    $object = User::build($fields);

    // check if name already exist in the database
    if ( !empty(User::findByUsername($object->username)) ) throw new Exception('User already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = User::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
