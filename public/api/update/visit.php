<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'visit_date' => Request::getAsString('visit_date'),
        'remarks' => Request::getAsRawString('remarks'),

    ];

    $object = Visit::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Update failed');

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

