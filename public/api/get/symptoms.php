<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


$id = Request::getAsInteger("id");

if ( !empty($id) ) {
    JSONResponse::validResponse(["data" => Symptom::find($id)]);
} else {
    JSONResponse::validResponse(["data" => Symptom::findAll()]);
}

