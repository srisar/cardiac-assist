<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Appointment;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );


try {

    $startDate = Request::getAsString( "start_date" );
    $endDate = Request::getAsString( "end_date" );

    if ( empty( $startDate ) ) $startDate = date( "Y-m-d" );
    if ( empty( $endDate ) ) $endDate = date( "Y-m-d" );

    $appointments = Appointment::betweenDates( $startDate, $endDate );

    JSONResponse::validResponse( [ "data" => $appointments ] );


} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
