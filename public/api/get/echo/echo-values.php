<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoValue;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();


$types = [
    'AORTA',
    'AORTIC_VALVE',
    'DOPPLER',
    'LEFT_ATRIUM',
    'MITRAL_VALVE',
    'PERICARDIUM',
    'PULMONIC_VALVE',
    'RIGHT_ATRIUM',
    'RIGHT_VENTRICLE',
    'TRICUSPID',
];

try {

    $id = Request::getAsInteger('id');
    $type = Request::getAsString('type');

    if (!is_null($id)) {
        // fetch by id

        $value = EchoValue::find($id);
        JSONResponse::validResponse($value);
        return;
    }

    if (!is_null($type)) {

        if (!in_array(strtoupper($type), $types)) throw new Exception('Invalid type');

        $values = EchoValue::findByType($type);
        JSONResponse::validResponse($values);
        return;

    }

    // find all values by their types
    $output = [];

    foreach ($types as $type){
        $output[$type] = EchoValue::findByType($type);
    }

    JSONResponse::validResponse($output);


} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
