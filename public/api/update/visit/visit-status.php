<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\Visit;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "status" => Request::getAsString("status"),
    ];

    if ( empty($fields["id"]) ) throw new Exception("Invalid id");

    $object = Visit::build($fields);

    if ( $fields["status"] == "COMPLETE" ) {
        $result = $object->setAsComplete();
    } else {
        $result = $object->setAsIncomplete();
    }

    if ( empty($result) ) throw new Exception("Update failed");

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

