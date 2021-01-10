<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'symptom_name' => Request::getAsString('symptom_name'),
        'description' => Request::getAsRawString('description'),

    ];

    $object = Symptom::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Symptom: Update failed');

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

