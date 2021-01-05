<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Book;
use App\Models\BookPurchase;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

try {

    $supplier_id = Request::getAsInteger('supplier_id');
    $start_date = Request::getAsString('start_date');
    $end_date = Request::getAsString('end_date');

    JSONResponse::validResponse(['data' => BookPurchase::filter($supplier_id, $start_date, $end_date)]);

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}