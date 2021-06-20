<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {

    $query = Request::getAsString("query");

    if (empty($query)) throw new Exception("Query is expected");

    if (explode(":", $query)[0] === "id") {
        $id = explode(":", $query)[1];
        if (isset($id) && !empty($id)) {
            JSONResponse::validResponse(["data" => [Patient::find($id)]]);
            return;
        }
    }

    $patients = Patient::search($query);
    JSONResponse::validResponse(["data" => $patients]);
    return;


} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
