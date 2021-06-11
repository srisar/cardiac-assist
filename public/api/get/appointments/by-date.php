<?php


use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Appointment;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


try {

    $date   = Request::getAsString("date");
    $status = Request::getAsString("status");

    if ( empty($date) ) $date = date("Y-m-d");
    if ( empty($status) ) $status = Appointment::STATUS_PENDING;


    $appointments = Appointment::findByDate($date, $status);

    JSONResponse::validResponse(["data" => $appointments]);


} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
