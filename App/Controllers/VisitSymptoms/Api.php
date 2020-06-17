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

    /**
     * Add a new visit-symptom
     */
    public function add()
    {

        try {

            /**
             * fields: visit_id, symptom_id
             */

            $fields = Axios::get();

            $isValid = true;

            if ( !isset($fields['visit_id']) || !isset($fields['symptom_id']) ) {
                JSONResponse::invalidResponse('Required fields missing: (visit_id, symptom_id)');
                return;
            }

            $visitSymptom = VisitSymptom::build($fields);


            $id = $visitSymptom->insert();

            if ( $id != false ) {
                $visitSymptom = VisitSymptom::find($id);

                JSONResponse::validResponse(['visit_symptom' => $visitSymptom]);
                return;

            }

            JSONResponse::invalidResponse('Failed adding new symptom');
            return;

        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
            return;
        }

    }


    /**
     * Delete existing visit-symptom
     */
    public function delete()
    {

        try {

            /**
             * field: id (visit-symptom id)
             */

            Axios::get();

            $id = Request::getAsInteger('id');

            $visitSymptom = VisitSymptom::find($id);

            if ( !empty($visitSymptom) ) {

                if ( $visitSymptom->delete() ) {
                    (new JSONResponse(['message' => 'Deleted!']))->response();
                    return;
                }

            }

            JSONResponse::invalidResponse();
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }


    /**
     *
     */
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

            if ( is_null($visitId) ) {
                JSONResponse::invalidResponse('Parameter (id) required');
                return;
            }

            $visit = Visit::find($visitId);

            if ( is_null($visit) ) {
                JSONResponse::invalidResponse('Invalid visit, check visit id');
                return;
            }

            $visitSymptoms = VisitSymptom::getVisitSymptomsByVisit($visit);

            foreach ( $visitSymptoms as $visitSymptom ) {
                $visitSymptom->symptom = $visitSymptom->getSymptom();
            }


            $output = [
                'visit' => $visit,
                'visit_symptoms' => $visitSymptoms
            ];


            JSONResponse::validResponse($output);
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

}