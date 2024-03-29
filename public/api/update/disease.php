<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Disease;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "disease" => Request::getAsString("disease"),
        "disease_code" => Request::getAsString("disease_code"),
        "description" => Request::getAsRawString("description"),

    ];

    $object = Disease::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception("Update failed");

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

