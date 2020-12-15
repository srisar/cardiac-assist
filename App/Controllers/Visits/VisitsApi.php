<?php


namespace App\Controllers\Visits;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit;
use Exception;

class VisitsApi
{


    /**
     * Add a new visit
     * Require: patient_id, visit_date, remarks
     */
    public function add()
    {

        try {

            $fields = Axios::get();
            $visit = Visit::build($fields);

            $result = $visit->insert();

            if ( $result != false ) {
                $visit = Visit::find($result);
                JSONResponse::validResponse(['visit' => $visit]);
                return;
            }
            throw new Exception('Failed to add a new visit');

        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }


    }


    /**
     * Updates existing visit (only the visit details)
     */
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