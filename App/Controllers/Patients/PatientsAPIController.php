<?php


namespace App\Controllers\Patients;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Models\Patient;

class PatientsAPIController
{

    public function adding()
    {

        $fields = Axios::get();

        $patient = Patient::build($fields);

        $result = $patient->insert();

        if ( $result != false ) {

            $patient = Patient::find($result);

            (new JSONResponse(["data" => $patient]))->response();
            return;
        }

        JSONResponse::invalidResponse(["data" => "Error adding a new patient"]);
        return;

    }


    /**
     * Required fields: offset, limit
     */
    public function getAll()
    {

        $fields = Axios::get();

        $patients = Patient::findAll();


        (new JSONResponse(["data" => $patients]))->response();
        return;

    }

}