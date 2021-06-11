<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\ReferralLetter;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "title" => Request::getAsString("title"),
        "letter_model" => Request::getAsRawString("letter_model"),
    ];

    $object = ReferralLetter::build($fields);

    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = ReferralLetter::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
