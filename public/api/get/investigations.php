<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Investigation;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {

    $id = Request::getAsInteger("id");

    if ( !empty($id) ) {
        JSONResponse::validResponse(["data" => Investigation::find($id)]);
    } else {
        JSONResponse::validResponse(["data" => Investigation::findAll()]);
    }


} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
