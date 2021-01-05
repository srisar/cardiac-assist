<?php

use App\AnalyticsHelper;
use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Book;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

try {

    $data = [
        'books_count' => AnalyticsHelper::getBooksCount(),
        'subjects_count' => AnalyticsHelper::getSubjectsCount(),
        'suppliers_count' => AnalyticsHelper::getSuppliersCount(),
    ];

    JSONResponse::validResponse(['data' => $data]);

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
