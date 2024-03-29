<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoRemark;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


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

try {

    $id = Request::getAsInteger("id");
    $type = Request::getAsString("type");

    if (!is_null($id)) {
        // fetch by id

        $value = EchoRemark::find($id);
        JSONResponse::validResponse($value);
        return;
    }

    if (!is_null($type)) {

        if (!in_array(strtoupper($type), $types)) throw new Exception("Invalid type");

        $values = EchoRemark::findByType($type);
        JSONResponse::validResponse($values);
        return;

    }

    // find all values by their types
    $output = [];

    foreach ($types as $type) {
        $output[$type] = EchoRemark::findByType($type);
    }

    JSONResponse::validResponse($output);


} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
