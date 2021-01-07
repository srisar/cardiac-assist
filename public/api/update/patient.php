<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'first_name' => Request::getAsString('first_name'),
        'last_name' => Request::getAsString('last_name'),
        'dob' => Request::getAsString('dob'),
        'age' => Request::getAsInteger('age'),
        'address' => Request::getAsString('address'),
        'ds_division' => Request::getAsString('ds_division'),
        'nic' => Request::getAsString('nic'),
        'phone' => Request::getAsString('phone'),
        'gender' => Request::getAsString('gender'),
        'job' => Request::getAsString('job'),
        'job_type' => Request::getAsString('job_type'),
        'income' => Request::getAsInteger('income'),
        'status' => Request::getAsString('status'),
    ];

    $object = Patient::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Patient: Update failed');

    JSONResponse::validResponse('Success');
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

