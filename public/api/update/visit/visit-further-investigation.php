<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitFurtherInvestigation;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "remarks" => Request::getAsRawString("remarks"),
    ];

    $o = VisitFurtherInvestigation::find($fields["id"]);

    if (empty($o)) throw new Exception("Invalid further investigation");

    $object = VisitFurtherInvestigation::build($fields);

    $result = $object->update();

    if (empty($result)) throw new Exception("Failed");

    JSONResponse::validResponse();
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

