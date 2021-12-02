<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitProblem;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "id" => Request::getAsInteger( "id" ),
        "remarks" => Request::getAsString( "remarks" ),
    ];

    $object = VisitProblem::build( $fields );

    $result = $object->update();

    if ( empty( $result ) ) throw new Exception( "Update failed" );

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}

