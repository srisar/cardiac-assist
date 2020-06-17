<?php


namespace App\Controllers\Visits;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;
use Exception;

class Api
{


    public function add()
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


    public function update()
    {

        try {

            /**
             * fields: visit_date, remarks, id
             */

            $fields = Axios::get();

            $visit = Visit::find($fields['id']);

            if ( !is_null($visit) ) {

                $visit->visit_date = $fields['visit_date'];
                $visit->remarks = $fields['remarks'];

                if ( $visit->update() ) {
                    JSONResponse::validResponse('Visit updated');
                    return;
                }

                JSONResponse::invalidResponse('Error updating visit details');
                return;
            }
            JSONResponse::invalidResponse('Visit doesnt exist');
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
            return;
        }

    }

    public function find()
    {

        try {

            /**
             * fields: id
             */
//            $fields = Axios::get();

            $id = Request::getAsInteger('id');

            $visit = Visit::find($id);

            if ( !is_null($visit) ) {
                JSONResponse::validResponse(['visit' => $visit]);
                return;
            }

            JSONResponse::invalidResponse('Invalid visit id');
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }


    }


}