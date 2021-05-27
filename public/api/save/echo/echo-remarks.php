<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoRemarks;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

$types = [
    'LEFT_VENTRICLE',
    'LEFT_ATRIUM',
    'MITRAL_VALVE',
    'AORTIC_VALVE',
    'AORTA',
    'RIGHT_VENTRICLE',
    'RIGHT_ATRIUM',
    'PULMONIC_VALVE',
    'TRICUSPID',
    'PERICARDIUM',
    'CONCLUSION',
];

try {

    $fields = [
        'value' => Request::getAsString('value'),
        'type' => strtoupper(Request::getAsString('type'))
    ];

    if (!is_null($fields['type'])) {

        if (!in_array(strtoupper($fields['type']), $types)) throw new Exception('Invalid type');

        $echoValue = EchoRemarks::build($fields);

        $result = $echoValue->insert();

        if ($result) {
            JSONResponse::validResponse([EchoRemarks::find($result)]);
            return;
        }

        throw new Exception('Failed');
    }

    return;

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
