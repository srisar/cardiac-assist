<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Appointment;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'patient_id' => Request::getAsInteger('patient_id'),
        'date' => Request::getAsString('date'),
        'remarks' => Request::getAsString('remarks'),
    ];

    $object = Appointment::build($fields);

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
