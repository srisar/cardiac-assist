<?php


namespace App\Controllers\VisitSymptoms;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;
use App\Models\VisitSymptom;
use Exception;

class Api
{

    public function adding()
    {

        try {

            /**
             * fields: visit_id, symptom_id
             */

            $fields = Axios::get();

            $visitSymptom = VisitSymptom::build($fields);


            $id = $visitSymptom->insert();

            if ( $id != false ) {
                $visitSymptom = VisitSymptom::find($id);

                (new JSONResponse(['visit_symptom' => $visitSymptom]))->response();
                return;

            }


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }


    public function findById()
    {

        try {

            /**
             * field: id
             */

            Axios::get();

            $id = Request::getAsInteger('id');

            $visitSymptom = VisitSymptom::find($id);


            (new JSONResponse(['visit_symptom' => $visitSymptom]))->response();
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }


    }


    public function getAllByVisit()
    {

        try {

            /**
             * field: id
             */

            Axios::get();

            $visitId = Request::getAsInteger('id');


            $visit = Visit::find($visitId);
            $visitSymptoms = VisitSymptom::getVisitSymptomsByVisit($visit);

            foreach ($visitSymptoms as $visitSymptom){
                $visitSymptom->symptom = $visitSymptom->getSymptom();
            }


            $output = [
                'visit' => $visit,
                'visit_symptoms' => $visitSymptoms
            ];


            (new JSONResponse($output))->response();
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

}