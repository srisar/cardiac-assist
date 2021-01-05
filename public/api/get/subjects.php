<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Models\Subject;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

JSONResponse::validResponse(['data' => Subject::findAll()]);