<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoRemark;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "id" => Request::getAsInteger( "id" ),
    ];

    if ( is_null( $fields["id"] ) ) throw new Exception( "Invalid Id" );

    $echoValue = EchoRemark::find( $fields["id"] );

    if ( is_null( $echoValue ) ) throw new Exception( "Invalid echo value" );

    $result = $echoValue->delete();

    if ( $result ) {
        JSONResponse::validResponse( "Deleted" );
        return;
    } else {
        throw new Exception( "Failed" );
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
