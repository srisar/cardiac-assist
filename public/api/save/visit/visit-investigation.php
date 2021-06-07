<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitInvestigation;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "investigation_id" => Request::getAsInteger("investigation_id"),
        "remarks" => Request::getAsRawString("remarks"),
    ];

    $object = VisitInvestigation::build($fields);

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception("Symptom already exist");

    $result = $object->insert();

    if ( empty($result) ) throw new Exception("Failed");

    $object = VisitInvestigation::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
