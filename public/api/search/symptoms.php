<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );


try {

    $query = Request::getAsString( "query" );

    if ( empty( $query ) ) {
        JSONResponse::validResponse( [ "data" => [] ] );
        return;
    }

    $drugs = Symptom::search( $query );
    JSONResponse::validResponse( [ "data" => $drugs ] );


} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
