<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitECG;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "description" => Request::getAsRawString("description"),
        "performed_on" => Request::getAsString("performed_on"),
        "indication" => Request::getAsRawString("indication"),
    ];

    if (empty($fields["id"])) throw new Exception("Invalid id");

    $object = VisitECG::build($fields);

    $result = $object->update();

    if (empty($result)) throw new Exception("Failed");

    JSONResponse::validResponse();

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

