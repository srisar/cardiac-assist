<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Appointment;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "id" => Request::getAsInteger( "id" ),
        "status" => Request::getAsString( "status" ),
    ];

    $appointment = Appointment::find( $fields["id"] );
    if ( empty( $appointment ) ) throw new Exception( "Invalid appointment" );

    $result = $appointment->updateStatus( $fields["status"] );

    if ( $result ) {
        JSONResponse::validResponse();
        return;
    }

    throw new Exception( "Failed to update the status" );

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}

