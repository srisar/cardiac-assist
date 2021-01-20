<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Investigation;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'visit_id' => Request::getAsInteger('visit_id'),
        'investigation_name' => Request::getAsString('investigation_name'),
        'description' => Request::getAsRawString('description'),
    ];

    $object = Investigation::build($fields);

    // check if name already exist in the database
//    if ( !empty(Symptom::findByName($object->symptom_name)) ) throw new Exception('Symptom already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = Investigation::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
