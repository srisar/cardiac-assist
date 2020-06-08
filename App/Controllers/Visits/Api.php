<?php


namespace App\Controllers\Visits;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Models\Visit;
use Exception;

class Api
{


    public function adding()
    {

        try {

            $fields = Axios::get();

            $visit = Visit::build($fields);

            $result = $visit->insert();

            if ( $result != false ) {
                (new JSONResponse(['patient' => Visit::find($result)]))->response();
                return;
            }

            JSONResponse::invalidResponse();
            return;


        } catch ( Exception $exception ) {
            JSONResponse::invalidResponse(['message' => $exception->getMessage()]);
        }


    }


}