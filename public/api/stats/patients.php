<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $stats = Patient::getTotalCount();

    JSONResponse::validResponse($stats);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

