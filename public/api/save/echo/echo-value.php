<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoValue;

require_once "../../../../_bootstrap.inc.php";

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

    $fields = [
        'value' => Request::getAsString('value'),
        'type' => strtoupper(Request::getAsString('type'))
    ];

    if (!is_null($fields['type'])) {

        if (!in_array(strtoupper($fields['type']), $types)) throw new Exception('Invalid type');

        $echoValue = EchoValue::build($fields);

        $result = $echoValue->insert();

        if ($result) {
            JSONResponse::validResponse([EchoValue::find($result)]);
            return;
        }

        throw new Exception('Failed');
    }

    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
