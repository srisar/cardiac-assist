<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitDiagnosis;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "disease_id" => Request::getAsInteger("disease_id"),
        "remarks" => Request::getAsString("remarks"),
    ];

    $object = VisitDiagnosis::build($fields);


    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = VisitDiagnosis::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
