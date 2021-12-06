<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoRemark;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );


try {

    $query = Request::getAsString( "query" );
    $type = Request::getAsString( "type" );

    if ( empty( $query ) ) {
        JSONResponse::validResponse( [ "data" => [] ] );
        return;
    }

    $results = EchoRemark::search( $query, $type );
    JSONResponse::validResponse( [ "data" => $results ] );


} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
