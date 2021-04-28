<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;
use App\Models\VisitECG;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();


try {

    $id = Request::getAsInteger('id');
    $visit_id = Request::getAsInteger('visit_id');

    if (!empty($id) || !empty($visit_id)) {

        if (!empty($id)) {
            JSONResponse::validResponse(['data' => VisitECG::find($id)]);
            die();

        } elseif (!empty($visit_id)) {
            $visit = Visit::find($visit_id);
            if (!empty($visit)) JSONResponse::validResponse(['data' => VisitECG::findByVisit($visit)]);
            else throw new Exception('Invalid visit');
        }

    } else {
        throw new Exception('Invalid id');
    }

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
