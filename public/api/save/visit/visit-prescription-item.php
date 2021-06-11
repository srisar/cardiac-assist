<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitPrescriptionItem;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "prescription_id" => Request::getAsInteger("prescription_id"),
        "drug_id" => Request::getAsInteger("drug_id"),
        "dose" => Request::getAsString("dose"),
        "frequency" => Request::getAsString("frequency"),
        "duration" => Request::getAsString("duration"),
        "remarks" => Request::getAsString("remarks"),
    ];


    if (
        empty($fields["prescription_id"]) || empty($fields["drug_id"]) || is_null($fields["dose"]) ||
        is_null($fields["frequency"]) || is_null($fields["duration"])
    ) {
        throw new Exception("Required fields are empty");
    }

    $object = VisitPrescriptionItem::build($fields);

    $result = $object->insert();

    if (empty($result)) throw new Exception("Failed");

    $object = VisitPrescriptionItem::find($result);

    JSONResponse::validResponse(["data" => $object]);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
