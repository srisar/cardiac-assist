<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

JSONResponse::validResponse(['data' => Patient::findAll()]);
