<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitCoronaryCT;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'visit_id' => Request::getAsString('visit_id'),
    ];

    $object = VisitCoronaryCT::build($fields);

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = VisitCoronaryCT::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
