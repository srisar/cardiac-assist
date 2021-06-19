<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitProblem;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "problem_id" => Request::getAsInteger("problem_id"),
    ];

    $object = VisitProblem::build($fields);


    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = VisitProblem::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
