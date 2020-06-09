<?php


namespace App\Controllers\Symptoms;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;
use Exception;

class Api
{

    public function adding()
    {
        try {

            $fields = Axios::get();


            if ( Symptom::findByName($fields['symptom_name']) == null ) {

                $symptom = Symptom::build($fields);

                $result = $symptom->insert();

                if ( $result ) {
                    (new JSONResponse(['symptom' => Symptom::find($result)]))->response();
                    return;
                }

                JSONResponse::invalidResponse(['message' => 'Error adding new symptom']);
                return;
            } else {

                JSONResponse::invalidResponse(['message' => 'Symptom already exists']);
                return;
            }


        } catch ( Exception $exception ) {
            JSONResponse::invalidResponse(['message' => $exception->getMessage()]);
        }

    }

    public function deleting()
    {

    }

    public function updating()
    {

    }

    public function getAll()
    {

        $symptoms = Symptom::findAll();

        (new JSONResponse(['symptoms' => $symptoms]))->response();

    }


    public function search()
    {

        try {

            Axios::get();

            $query = Request::getAsString('query');

            if ( !empty($query) )
                $symptoms = Symptom::searchByName(Request::getAsString('query'));
            else
                $symptoms = [];

            (new JSONResponse(['symptoms' => $symptoms]))->response();
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

    public function find()
    {
        try {

            /**
             * fields: $id
             */

            $fields = Axios::get();

            $id = Request::getAsInteger('id');

            error_log(print_r($_REQUEST, true));
            error_log(print_r($fields, true));

            if ( is_null($id) ) {
                JSONResponse::invalidResponse();
                return;
            }


            $symptom = Symptom::find($id);

            if ( $symptom != null ) {
                (new JSONResponse(['symptom' => $symptom]))->response();
                return;
            }

            JSONResponse::invalidResponse(['message' => 'Invalid id']);
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

}