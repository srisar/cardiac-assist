<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;

require_once "../../../../_bootstrap.inc.php";

try {

    $fields = [
        'id'    => Request::getAsInteger('id'),
        'value' => Request::getAsString('value'),

    ];

    $object = \App\Models\EchoAortaValue::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Update failed');

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

