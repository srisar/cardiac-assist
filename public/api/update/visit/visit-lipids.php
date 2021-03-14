<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitECG;
use App\Models\VisitLipid;

require_once "../../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'tc' => Request::getAsFloat('tc'),
        'ldl' => Request::getAsFloat('ldl'),
        'hdl' => Request::getAsFloat('hdl'),
        'tg' => Request::getAsFloat('tg'),
        'nhc' => Request::getAsFloat('nhc'),
    ];

    if ( empty($fields['id']) ) throw new Exception('Invalid id');

    $object = VisitLipid::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Failed');

    JSONResponse::validResponse();

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

