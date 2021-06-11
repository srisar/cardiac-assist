<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitPrescriptionItem;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {
    $id = Request::getAsInteger("id");

    if (!empty($id)) {

        JSONResponse::validResponse(["item" => VisitPrescriptionItem::find($id)]);
        return;

    } else {
        throw new Exception("Invalid id");
    }

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
