<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\Visit;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {

    $id = Request::getAsInteger("id");

    if (!empty($id)) {

        if (!empty(Visit::find($id))) JSONResponse::validResponse(["data" => true]);
        else JSONResponse::validResponse(["data" => false]);

    }


} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
