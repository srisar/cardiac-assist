<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Models\Visit\VisitInvestigation;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $allInvestigations = VisitInvestigation::getCommonStats();

    $output = [
        'investigations' => $allInvestigations,
    ];

    JSONResponse::validResponse( $output );
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}

