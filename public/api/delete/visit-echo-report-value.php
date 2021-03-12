<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;

require_once "../../../_bootstrap.inc.php";


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

    $fields = [
        'visit_id'    => Request::getAsInteger('visit_id'),
        'value_id'    => Request::getAsInteger('value_id'),
        'report_type' => Request::getAsString('report_type'),
    ];

    if ( empty($fields['visit_id']) || empty($fields['value_id']) ) throw new Exception('Required fields missing');

    error_log(print_r($fields, true));

    if ( !in_array($fields['report_type'], $tables) ) throw new Exception('Invalid report type');

    $result = \App\Models\VisitEchoReportValues::delete($fields['visit_id'], $fields['value_id'], $fields['report_type']);

    error_log($result);

    if ( $result ) {
        JSONResponse::validResponse('Deleted');
        return;
    } else {
        throw new Exception('Failed');
    }

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
