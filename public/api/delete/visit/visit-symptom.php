<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitSymptom;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
    ];

    $object = VisitSymptom::build($fields);


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
