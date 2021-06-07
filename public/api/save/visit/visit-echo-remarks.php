<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitEchoValue;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $types = [
        "LEFT_VENTRICLE",
        "LEFT_ATRIUM",
        "MITRAL_VALVE",
        "AORTIC_VALVE",
        "AORTA",
        "RIGHT_VENTRICLE",
        "RIGHT_ATRIUM",
        "PULMONIC_VALVE",
        "TRICUSPID",
        "PERICARDIUM",
        "CONCLUSION",
    ];


    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "echo_value_id" => Request::getAsInteger("echo_value_id"),
        "type" => strtoupper(Request::getAsString("type")),
    ];

    if (!in_array($fields["type"], $types)) throw new Exception("Invalid type");


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
