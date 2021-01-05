<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Book;
use App\Models\BookPurchase;
use App\Models\Subject;
use App\Models\Supplier;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'purchase_date' => Request::getAsString('purchase_date'),
        'supplier_id' => Request::getAsString('supplier_id'),
        'book_id' => Request::getAsString('book_id'),
        'unit_price' => Request::getAsString('unit_price'),
        'quantity' => Request::getAsString('quantity'),
    ];


    $object = BookPurchase::build($fields);

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed');

    $object = Subject::find($result);

    JSONResponse::validResponse(['data' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
