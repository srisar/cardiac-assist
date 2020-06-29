<?php

declare(strict_types=1);

namespace App\Controllers\Symptoms;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Symptom;
use Exception;

class Api
{

    public function add()
    {
        try {

            /**
             * fields: symptom_name, description
             */

            $fields = Axios::get();

            /*
             * server side validation
             * fields: symptom_name
             */

            if ( empty($fields['symptom_name']) ) {
                JSONResponse::invalidResponse('Symptom name cannot be empty');
                return;
            }


            if ( Symptom::findByName($fields['symptom_name']) == null ) {


                $symptom = Symptom::build($fields);

                $result = $symptom->insert();

                if ( $result ) {
                    (new JSONResponse(['symptom' => Symptom::find((int)$result)]))->response();
                    return;
                }

                JSONResponse::invalidResponse('Error adding new symptom');
                return;
            } else {

                JSONResponse::invalidResponse('Symptom already exists');
                return;
            }


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

    public function update()
    {

        try {


            /**
             * fields: id, symptom_name, description
             * required: id, symptom_name
             */
            $fields = Axios::get();

            if ( empty($fields['id']) ) {
                throw new Exception('Invalid id');
            }
            if ( empty($fields['symptom_name']) ) {
                throw new Exception('Invalid symptom name');
            }

            $symptom = Symptom::find($fields['id']);

            if ( !empty($symptom) ) {

                $symptom->symptom_name = $fields['symptom_name'];
                $symptom->description = $fields['description'];

                if ( $symptom->update() ) {
                    JSONResponse::validResponse('Updated');
                    return;
                }

            }

            throw new Exception('Invalid symptom; Check your symptom id.');


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

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