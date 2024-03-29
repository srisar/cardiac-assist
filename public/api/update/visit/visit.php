<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\Visit;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "id" => Request::getAsInteger( "id" ),
        "visit_date" => Request::getAsString( "visit_date" ),
        "remarks" => Request::getAsString( "remarks" ),

        "height" => Request::getAsFloat( "height" ),
        "weight" => Request::getAsFloat( "weight" ),
        "bmi" => Request::getAsFloat( "bmi" ),
        "bsa" => Request::getAsFloat( "bsa" ),
        "dbp" => Request::getAsFloat( "dbp" ),
        "sbp" => Request::getAsFloat( "sbp" ),
        "ef" => Request::getAsFloat( "ef" ),

        "dm" => Request::getAsBoolean( "dm" ),
        "ht" => Request::getAsBoolean( "ht" ),
        "dl" => Request::getAsBoolean( "dl" ),

        "smoking" => Request::getAsString( "smoking" ),
        "family_history" => Request::getAsString( "family_history" ),

        "heart_beat" => Request::getAsInteger( "heart_beat" ),
        "performed_by" => Request::getAsString( "performed_by" ),
    ];


    $object = Visit::build( $fields );


    $result = $object->update();

    if ( empty( $result ) ) throw new Exception( "Update failed" );

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}

