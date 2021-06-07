<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Drug;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {

    $query = Request::getAsString("query");

    $drugs = Drug::search($query);
    JSONResponse::validResponse(["drugs" => $drugs]);


} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
