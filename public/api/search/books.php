<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Book;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();


$query = Request::getAsString('query');


JSONResponse::validResponse(['data' => Book::search($query)]);
