<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitEchoValue;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {


    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "echo_value_id" => Request::getAsInteger("echo_value_id"),
    ];


    $object = VisitEchoValue::build($fields);

    $result = $object->insert();

    if ($result) {
        JSONResponse::validResponse();
        return;
    }

    if (empty($result)) throw new Exception("Failed");

    JSONResponse::validResponse();
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
