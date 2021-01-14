<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsString('id'),
    ];

    $object = Symptom::build($fields);


    $result = $object->delete();

    if ( $result ) {
        JSONResponse::validResponse('Deleted');
        return;
    } else {
        throw new Exception('Failed');
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
