<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {

    $query = Request::getAsString("query");

    if(empty($query)) throw new Exception("Query is expected");

    $drugs = Patient::search($query);
    JSONResponse::validResponse(["data" => $drugs]);


} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
