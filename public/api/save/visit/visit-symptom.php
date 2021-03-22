<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;
use App\Models\User;
use App\Models\VisitSymptom;

require_once "../../../../_bootstrap.inc.php";

try {

    $fields = [
        'visit_id' => Request::getAsString('visit_id'),
        'symptom_id' => Request::getAsInteger('symptom_id'),
        'duration' => Request::getAsString('duration'),
    ];

    $object = VisitSymptom::build($fields);

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception('Symptom already exist');

    $result = $object->insert();

    if (empty($result)) throw new Exception('Failed');

    $object = Symptom::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
