<?php


namespace App\Controllers\Diseases;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Disease;
use Exception;

class Api
{
    public function add()
    {
        try {

            /**
             * fields: disease, disease_code
             */

            $fields = Axios::get();

            /*
             * server side validation
             * fields: disease
             */

            if ( empty($fields['disease']) ) throw new Exception('Invalid disease name');


            if ( Disease::findByName($fields['disease']) == null ) {


                $disease = Disease::build($fields);

                $result = $disease->insert();

                if ( $result ) {
                    JSONResponse::validResponse(['disease' => Disease::find($result)]);
                    return;
                }

                throw new Exception('Error adding new disease');
            } else {

                throw new Exception('Disease already exists.');
            }


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

    public function update()
    {
        try {

            /**
             * fields: id, disease, disease_code, description
             * validation: id, disease
             */

            $fields = Axios::get();

            if ( empty($fields['id']) ) throw new Exception("Disease id missing");
            if ( empty($fields['disease']) ) throw new Exception("Disease name missing");


            $disease = Disease::build($fields);

            if ( $disease->update() ) {
                JSONResponse::validResponse('Updated');
                return null;
            }

            throw new Exception('Failed to update disease');


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }
    }


    public function getAll()
    {

        $diseases = Disease::findAll();
        JSONResponse::validResponse(['diseases' => $diseases]);
        return null;
    }


    public function search()
    {

        try {

            Axios::get();

            $query = Request::getAsString('query');

            if ( !empty($query) )
                $diseases = Disease::searchByName(Request::getAsString('query'));
            else
                $diseases = [];

            JSONResponse::validResponse(['diseases' => $diseases]);
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

}