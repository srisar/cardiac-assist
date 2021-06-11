<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\ReferralLetter;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
    ];

    $object = ReferralLetter::find($fields["id"]);
    if (empty($object)) throw new Exception("Invalid id");

    $object = ReferralLetter::build($fields);


    $result = $object->delete();

    if ($result) {
        JSONResponse::validResponse("Deleted");
        return;
    } else {
        throw new Exception("Failed");
    }

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
