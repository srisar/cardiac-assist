<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();


$id = Request::getAsInteger('id');

if ( !empty($id) ) {
    JSONResponse::validResponse(['data' => Patient::find($id)]);
} else {
    JSONResponse::validResponse(['data' => Patient::findAll()]);
}

