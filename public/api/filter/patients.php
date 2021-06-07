<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);


$filters = [
    "gender" => Request::getAsString("gender"),
    "age_start" => Request::getAsInteger("age_start"),
    "age_end" => Request::getAsInteger("age_end"),
];

$gender = $filters["gender"];

if ( empty($filters["age_start"]) || empty($filters["age_end"]) ) {
    $age = [0, 100];
} else {
    $age = [$filters["age_start"], $filters["age_end"]];
}

$data = Patient::filter($gender, $age);

JSONResponse::validResponse(["data" => $data]);
