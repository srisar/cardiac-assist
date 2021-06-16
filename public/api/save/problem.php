<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Problem;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "problem" => Request::getAsString("problem"),
    ];

    $object = Problem::build($fields);

    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = Problem::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
