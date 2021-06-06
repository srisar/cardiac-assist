<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitPrescription;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

try {

    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "remarks" => Request::getAsRawString("remarks"),
        "date" => Request::getAsString("date"),
    ];


    if (empty($fields["visit_id"]) || is_null($fields["remarks"]) || is_null($fields["date"])) throw new Exception("Required fields are empty");

    $object = VisitPrescription::build($fields);

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception("Symptom already exist");

    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = VisitPrescription::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
