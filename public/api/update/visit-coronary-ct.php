<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitECG;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id'                     => Request::getAsInteger('id'),
        'total_calcium_score'    => Request::getAsInteger('total_calcium_score'),
        'origin'                 => Request::getAsString('origin'),
        'dominance'              => Request::getAsString('dominance'),
        'left_main'              => Request::getAsString('left_main'),
        'lad'                    => Request::getAsString('lad'),
        'lcx'                    => Request::getAsString('lcx'),
        'cardiac_valves'         => Request::getAsString('cardiac_valves'),
        'pericardium'            => Request::getAsString('pericardium'),
        'extra_cardiac_findings' => Request::getAsString('extra_cardiac_findings'),
        'impression'             => Request::getAsString('impression'),
    ];

    if ( empty($fields['id']) ) throw new Exception('Invalid id');

    $object = VisitECG::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Failed');

    JSONResponse::validResponse();

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

