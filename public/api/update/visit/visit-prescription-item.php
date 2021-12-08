<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitPrescriptionItem;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "id" => Request::getAsInteger( "id" ),
        "dose" => Request::getAsString( "dose" ),
        "frequency" => Request::getAsString( "frequency" ),
        "duration" => Request::getAsString( "duration" ),
        "remarks" => Request::getAsString( "remarks" ),
    ];

    $object = VisitPrescriptionItem::build( $fields );

    $result = $object->update();

    if ( empty( $result ) ) throw new Exception( "Update failed" );

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}

