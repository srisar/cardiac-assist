<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;
use App\Models\VisitEchoReportValues;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

$tables = [
    'echo_aorta_values',
    'echo_aortic_valve_values',
    'echo_doppler_values',
    'echo_left_atrium_values',
    'echo_left_ventricle_values',
    'echo_mitral_valve_values',
    'echo_pericardium_values',
    'echo_pulmonic_valve_values',
    'echo_right_atrium_values',
    'echo_right_ventricle_values',
    'echo_tricuspid_values',
];


try {
    $visit_id    = Request::getAsInteger('visit_id');
    $report_type = Request::getAsString('report_type');

    if ( !in_array($report_type, $tables) ) throw new Exception('Invalid report type');

    if ( !empty($visit_id) && !empty($report_type) ) {
        $visit = Visit::find($visit_id);

        if ( !empty($visit) ) {

            $result = VisitEchoReportValues::findAllByVisit($visit, $report_type);

            JSONResponse::validResponse(['data' => $result]);

        } else {
            throw new Exception('Invalid visit');
        }
    } else {
        throw new Exception('Invalid request / missing parameters');
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
