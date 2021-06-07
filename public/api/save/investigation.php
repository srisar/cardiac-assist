<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Investigation;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "investigation_name" => Request::getAsString("investigation_name"),
        "description" => Request::getAsRawString("description"),
    ];

    $object = Investigation::build($fields);

    // check if name already exist in the database
    if ( !empty(Investigation::findByName($object->investigation_name)) ) throw new Exception("Investigation already exist");

    $result = $object->insert();

    if ( empty($result) ) throw new Exception("Failed");

    $object = Symptom::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
