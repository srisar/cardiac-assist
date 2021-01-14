<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'patient_id' => Request::getAsInteger('patient_id'),
        'visit_date' => Request::getAsString('visit_date'),
        'remarks' => Request::getAsString('remarks'),
    ];

    $object = Visit::build($fields);

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->disease)) ) throw new Exception('Disease already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');


    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
