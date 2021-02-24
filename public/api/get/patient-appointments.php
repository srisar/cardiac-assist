<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();


try {
    $id = Request::getAsInteger('id');

    if ( !empty($id) ) {

        $patient = Patient::find($id);

        JSONResponse::validResponse(['data' => $patient->getAppointments()]);

    } else {
        throw new Exception('Invalid patient');
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
