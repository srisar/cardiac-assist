<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\Visit;
use App\Models\Visit\VisitEchoRemark;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

$types = [
    "LEFT_VENTRICLE",
    "LEFT_ATRIUM",
    "MITRAL_VALVE",
    "AORTIC_VALVE",
    "AORTA",
    "RIGHT_VENTRICLE",
    "RIGHT_ATRIUM",
    "PULMONIC_VALVE",
    "TRICUSPID",
    "PERICARDIUM",
    "CONCLUSION",
];


try {

    $visit_id = Request::getAsInteger( "visit_id" );

    if ( is_null( $visit_id ) ) throw new Exception( "Invalid visit" );

    $visit = Visit::find( $visit_id );

    if ( is_null( $visit ) ) throw new Exception( "Invalid visit" );


    // find all values by their types
    $output = [];

    foreach ( $types as $type ) {
        $output[ $type ] = VisitEchoRemark::findByVisitAndType( $visit, $type );
    }

    JSONResponse::validResponse( $output );
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
