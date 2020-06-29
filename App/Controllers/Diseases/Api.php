<?php


namespace App\Controllers\Diseases;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Disease;
use App\Models\Symptom;
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

            if ( empty($fields['disease']) ) {
                JSONResponse::invalidResponse('Disease name cannot be empty');
                return;
            }


            if ( Disease::findByName($fields['disease']) == null ) {


                $disease = Disease::build($fields);

                $result = $disease->insert();

                if ( $result ) {
                    JSONResponse::validResponse(['disease' => Disease::find($result)]);
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


    public function getAll()
    {

        $diseases = Disease::findAll();
        JSONResponse::validResponse(['diseases' => $diseases]);
        return;
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