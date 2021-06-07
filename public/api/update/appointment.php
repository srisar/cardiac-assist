<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Appointment;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "date" => Request::getAsString("date"),
        "remarks" => Request::getAsString("remarks"),
        "status" => Request::getAsString("status"),
    ];

    $object = Appointment::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception("Failed");

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

