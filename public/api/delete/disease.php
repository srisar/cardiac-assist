<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Disease;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
    ];

    $object = Disease::find($fields["id"]);
    if (empty($object)) throw new Exception("Invalid id");

    $object = Disease::build($fields);

    $result = $object->delete();

    if ( $result ) {
        JSONResponse::validResponse("Deleted");
        return;
    } else {
        throw new Exception("Failed");
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
