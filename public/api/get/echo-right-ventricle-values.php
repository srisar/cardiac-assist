<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();


$id = Request::getAsInteger('id');

if ( !empty($id) ) {
    JSONResponse::validResponse(['data' => \App\Models\EchoRightVentricleValue::find($id)]);
} else {
    JSONResponse::validResponse(['data' => \App\Models\EchoRightVentricleValue::findAll()]);
}
