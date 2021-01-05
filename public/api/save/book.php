<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Book;
use App\Models\Subject;
use App\Models\Supplier;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'book_title' => Request::getAsString('book_title'),
        'subject_id' => Request::getAsString('subject_id'),
    ];

    if ( empty($fields['book_title']) ) throw  new Exception('Book title is empty');

    $object = Book::build($fields);

    // check if name already exist in the database
    if ( Book::alreadyExists($object) ) throw new Exception('Book already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = Subject::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
