<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\User;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "display_name" => Request::getAsString("display_name"),
        "password_string" => Request::getAsString("password"),
        "role" => Request::getAsString("role"),
    ];

    $changePassword = Request::getAsString("change_password");

    $object = User::build($fields);

    if ( $changePassword == "true" )
        $result = $object->updateWithPassword();
    else
        $result = $object->update();

    if ( empty($result) ) throw new Exception("Update failed");

    JSONResponse::validResponse("success");
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

