<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Subject;
use App\Models\Supplier;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'subject_name' => Request::getAsString('subject_name'),
    ];

    if ( empty($fields['subject_name']) ) throw  new Exception('Subject is empty');

    $object = Subject::build($fields);

    // check if name already exist in the database
    if ( !empty(Subject::getSubjectByName($object->subject_name)) ) throw new Exception('Subject already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = Subject::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
