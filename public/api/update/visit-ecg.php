<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitECG;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'description' => Request::getAsRawString('description'),
    ];

    if ( empty($fields['id']) ) throw new Exception('Invalid id');

    $object = VisitECG::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Failed');

    JSONResponse::validResponse();

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

