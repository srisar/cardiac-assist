<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "symptom_name" => Request::getAsString("symptom_name"),
        "description" => Request::getAsRawString("description"),
    ];

    $object = Symptom::build($fields);

    // check if name already exist in the database
    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception("Symptom already exist");

    $result = $object->insert();

    if ( empty($result) ) throw new Exception("Failed");

    $object = Symptom::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
