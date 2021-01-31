<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitECG;
use App\Models\VisitLipid;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'visit_id' => Request::getAsString('visit_id'),
        'tc' => Request::getAsFloat('tc'),
        'ldl' => Request::getAsFloat('ldl'),
        'hdl' => Request::getAsFloat('hdl'),
        'tg' => Request::getAsFloat('tg'),
        'nhc' => Request::getAsFloat('nhc'),
    ];

    $object = VisitLipid::build($fields);

    error_log(print_r($_POST, true));
    error_log(print_r($object, true));

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception('Symptom already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = VisitLipid::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
