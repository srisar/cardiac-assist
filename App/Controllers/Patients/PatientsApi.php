<?php


namespace App\Controllers\Patients;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Models\Patient;
use Exception;

class PatientsApi
{

    /**
     * Required fields: offset, limit
     */
    public function getAll()
    {

        try {
            $fields = Axios::get();

            $patients = Patient::findAll();

            (new JSONResponse(['data' => $patients]))->response();
            return;

        } catch ( Exception $exception ) {
            JSONResponse::invalidResponse(['data' => $exception->getMessage()]);
        }

    }


    /**
     * Add a new patient
     */
    public function add()
    {

        $fields = Axios::get();

        $patient = Patient::build($fields);

        $result = $patient->insert();

        if ( $result != false ) {

            $patient = Patient::find($result);

            JSONResponse::validResponse(['patient' => $patient]);
            return;
        }

        JSONResponse::invalidResponse('Error adding a new patient');
    }


    /**
     * Update existing patient
     */
    public function update()
    {

        try {
            $fields = Axios::get();

            $patient = Patient::find($fields['id']);

            if ( !is_null($patient) ) {

                $patient_ = Patient::build($fields);

                if ( $patient_->update() ) {
                    (new JSONResponse(['data' => "Updated!"]))->response();
                    return;
                }
                JSONResponse::invalidResponse();
                return;

            }
            JSONResponse::invalidResponse();
            return;

        } catch ( Exception $exception ) {
            JSONResponse::invalidResponse(['data' => $exception->getMessage()]);
        }

    }

}