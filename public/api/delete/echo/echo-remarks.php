<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\EchoRemarks;

require_once "../../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
    ];

    if (is_null($fields['id'])) throw new Exception('Invalid Id');

    $echoValue = EchoRemarks::find($fields['id']);

    if (is_null($echoValue)) throw new Exception('Invalid echo value');

    $result = $echoValue->delete();

    if ($result) {
        JSONResponse::validResponse('Deleted');
        return;
    } else {
        throw new Exception('Failed');
    }

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}
