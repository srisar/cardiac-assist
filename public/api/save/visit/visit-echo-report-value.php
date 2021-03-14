<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;

require_once "../../../../_bootstrap.inc.php";

try {

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


    $visit_id    = Request::getAsInteger('visit_id');
    $value_id    = Request::getAsInteger('value_id');
    $report_type = Request::getAsString('report_type');

    if ( !in_array($report_type, $tables) ) throw new Exception('Invalid report type');
    if ( empty($visit_id) || empty($value_id) ) throw new Exception('Required fields missing');


    $result = \App\Models\VisitEchoReportValues::insert($visit_id, $value_id, $report_type);

    if ( empty($result) ) throw new Exception('Failed');

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
