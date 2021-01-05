<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Book;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'book_title' => Request::getAsString('book_title'),
        'subject_id' => Request::getAsString('subject_id'),
    ];

    if ( empty($fields['book_title']) ) throw  new Exception('Book title is empty');

    $object = Book::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Failed to update book');

    JSONResponse::validResponse('success');
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

