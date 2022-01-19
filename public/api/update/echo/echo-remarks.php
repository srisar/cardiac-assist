<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoRemark;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "value" => Request::getAsString("value"),
        "fillable" => Request::getAsString("fillable")
    ];

    $object = EchoRemark::build($fields);

    $result = $object->update();

    if (empty($result)) throw new Exception("Update failed");

    JSONResponse::validResponse();
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

