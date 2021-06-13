<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\Visit;
use App\Models\Visit\VisitReferralLetter;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "visit_id" => Request::getAsInteger("visit_id"),
        "title" => Request::getAsString("title"),
        "letter" => Request::getAsRawString("letter"),
    ];

    /* validate visit */
    if (empty(Visit::find($fields["visit_id"]))) throw new Exception("Invalid visit");


    $object = VisitReferralLetter::build($fields);

    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = VisitReferralLetter::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
