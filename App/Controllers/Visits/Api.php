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


    public function updating()
    {

        try {


            $fields = Axios::get();

            $visit = Visit::find($fields['id']);

            if ( !is_null($visit) ) {

                $visit->visit_date = $fields['visit_date'];
                $visit->remarks = $fields['remarks'];

                if ( $visit->update() ) {
                    (new JSONResponse(['message' => 'Visit updated']))->response();
                    return;
                }

                JSONResponse::invalidResponse(['message' => 'Error updating visit details']);
                return;
            }
            JSONResponse::invalidResponse(['message' => 'Visit doesnt exits']);
            return;


        } catch ( Exception $exception ) {
            JSONResponse::invalidResponse(['message' => $exception->getMessage()]);
            return;
        }

    }


}