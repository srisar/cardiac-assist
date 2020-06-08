<?php


namespace App\Controllers\Symptoms;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
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
            JSONResponse::invalidResponse();
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

}