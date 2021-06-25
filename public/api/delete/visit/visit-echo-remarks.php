<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitEchoRemark;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $id = Request::getAsInteger( "id" );

    if ( is_null( $id ) ) throw new Exception( "Invalid id" );

    $object = VisitEchoRemark::find( $id );

    if ( is_null( $object ) ) throw new Exception( "Invalid id" );

    $result = $object->delete();


    if ( $result ) {
        JSONResponse::validResponse( "Deleted" );
        return;
    } else {
        throw new Exception( "Failed" );
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
