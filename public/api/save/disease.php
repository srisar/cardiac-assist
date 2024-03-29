<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Disease;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "disease" => Request::getAsString( "disease" ),
        "disease_code" => Request::getAsString( "disease_code" ),
        "description" => Request::getAsRawString( "description" ),
    ];

    $object = Disease::build( $fields );

    // check if name already exist in the database
    if ( !empty( Disease::findByName( $object->disease ) ) ) throw new Exception( "Disease already exist" );

    $result = $object->insert();

    if ( empty( $result ) ) throw new Exception( "Failed" );

    $object = Disease::find( $result );

    JSONResponse::validResponse( [ "data" => $object ] );
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
