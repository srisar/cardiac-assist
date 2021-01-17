<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\DifferentialDiagnosis;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'visit_id' => Request::getAsInteger('visit_id'),
        'disease_id' => Request::getAsInteger('disease_id'),
        'remarks' => Request::getAsString('remarks'),
    ];

    $object = DifferentialDiagnosis::build($fields);

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception('Symptom already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = DifferentialDiagnosis::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
