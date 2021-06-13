<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\Visit;
use App\Models\Visit\VisitReferralLetter;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {
    $id = Request::getAsInteger("id");
    $visit_id = Request::getAsInteger("visit_id");

    if (!empty($id) || !empty($visit_id)) {

        if (!empty($id)) {
            JSONResponse::validResponse(["data" => VisitReferralLetter::find($id)]);

        } elseif (!empty($visit_id)) {
            $visit = Visit::find($visit_id);

            if (empty($visit)) throw new Exception("Invalid visit");

            JSONResponse::validResponse(["data" => VisitReferralLetter::findByVisit($visit)]);
        }

    } else {
        throw new Exception("Invalid id");
    }

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
