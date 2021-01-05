<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Supplier;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id' => Request::getAsInteger('id'),
        'supplier_name' => Request::getAsString('supplier_name'),
        'address' => Request::getAsString('address'),
        'telephone' => Request::getAsString('telephone'),
        'email' => Request::getAsString('email'),
        'website' => Request::getAsString('website'),
    ];

    if ( empty($fields['supplier_name']) ) throw  new Exception('Supplier name is empty');

    $supplier = Supplier::build($fields);

    $result = $supplier->update();

    if ( empty($result) ) throw new Exception('Failed to update supplier');

    JSONResponse::validResponse('success');
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

