<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Drug;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "drug_name" => Request::getAsString("drug_name"),
        "remarks" => Request::getAsString("remarks"),
    ];

    $object = Drug::build($fields);

    // check if name already exist in the database
    if (!empty(Drug::findByName($object->drug_name))) throw new Exception("Drug already exist");

    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = Drug::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
