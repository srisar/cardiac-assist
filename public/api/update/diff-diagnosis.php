<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\DifferentialDiagnosis;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'remarks' => Request::getAsString('remarks'),
    ];

    $object = DifferentialDiagnosis::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Update failed');

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

