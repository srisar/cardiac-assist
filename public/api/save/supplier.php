<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Supplier;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'supplier_name' => Request::getAsString('supplier_name'),
        'address' => Request::getAsString('address'),
        'telephone' => Request::getAsString('telephone'),
        'email' => Request::getAsString('email'),
        'website' => Request::getAsString('website'),
    ];

    if ( empty($fields['supplier_name']) ) throw  new Exception('Supplier name is empty');

    $object = Supplier::build($fields);

    // check if name already exist in the database
    if ( !empty(Supplier::getSupplierByName($object->supplier_name)) ) throw new Exception('Supplier already exist');

    $result = $object->insert();

    if ( empty($result) ) throw new Exception('Failed to insert a new supplier');

    $object = Supplier::find($result);

    JSONResponse::validResponse(['supplier' => $object]);
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}
