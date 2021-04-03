<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;
use App\Models\VisitEchoValue;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

$types = [
    'AORTA',
    'AORTIC_VALVE',
    'DOPPLER',
    'LEFT_ATRIUM',
    'MITRAL_VALVE',
    'PERICARDIUM',
    'PULMONIC_VALVE',
    'RIGHT_ATRIUM',
    'RIGHT_VENTRICLE',
    'TRICUSPID',
];


try {

    $visit_id = Request::getAsInteger('visit_id');

    if (is_null($visit_id)) throw new Exception('Invalid visit');

    $visit = Visit::find($visit_id);

    if (is_null($visit)) throw new Exception('Invalid visit');


    // find all values by their types
    $output = [];

    foreach ($types as $type) {
        $output[$type] = VisitEchoValue::findByVisitAndType($visit, $type);
    }

    JSONResponse::validResponse($output);
    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
