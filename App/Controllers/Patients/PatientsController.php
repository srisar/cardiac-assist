<?php


namespace App\Controllers\Patients;


use App\Core\App;
use App\Core\Requests\Request;
use App\Core\View;
use App\Models\Patient;

class PatientsController
{

    public function viewAdd()
    {
        View::render('patients/add.view');
    }

    public function viewAll()
    {
        View::render('patients/all.view');
    }

    public function viewEdit()
    {

        $id = Request::getAsInteger('id');

        $patient = Patient::find($id);

        if ( !is_null($patient) ) {

            View::setData("patient", $patient);
            View::render("patients/edit.view");
            return;
        }

        App::redirect('/patients');

    }
}