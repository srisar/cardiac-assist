<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Drug;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "drug_name" => Request::getAsString("drug_name"),
        "remarks" => Request::getAsString("remarks"),

    ];

    $object = Drug::build($fields);

    $result = $object->update();

    if (empty($result)) throw new Exception("Update failed");

    JSONResponse::validResponse();
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

