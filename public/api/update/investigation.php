<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Investigation;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "investigation_name" => Request::getAsString("investigation_name"),
        "description" => Request::getAsRawString("description"),
    ];

    $object = Investigation::build($fields);

    /*
     * Before update, check if the new investigation name already
     * exist for other investigation, if already exists, then
     * update should not happen
     * */

    $x = Investigation::findByName($fields["investigation_name"]);

    if ( !empty($x) ) {
        if ( $x->id != $object->id ) throw new Exception("Investigation name already exists");
    }

    $result = $object->update();

    if ( empty($result) ) throw new Exception("Failed");

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

