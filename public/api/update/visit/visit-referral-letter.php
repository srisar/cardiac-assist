<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitReferralLetter;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "title" => Request::getAsString("title"),
        "letter" => Request::getAsRawString("letter"),
    ];

    if (empty(VisitReferralLetter::find($fields["id"]))) throw new Exception("Invalid letter");

    $object = VisitReferralLetter::build($fields);

    $result = $object->update();

    if (empty($result)) throw new Exception("Update failed");

    JSONResponse::validResponse();
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

