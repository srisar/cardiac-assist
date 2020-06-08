<?php


namespace App\Controllers\VisitSymptoms;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
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

            if($id != false){
                $visitSymptom = VisitSymptom::find($id);



            }


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

}