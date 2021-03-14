<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;

require_once "../../../../_bootstrap.inc.php";

try {

    $fields = [
        'value' => Request::getAsString('value'),
    ];

    $object = \App\Models\EchoLeftAtriumValue::build($fields);

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = \App\Models\EchoLeftAtriumValue::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
