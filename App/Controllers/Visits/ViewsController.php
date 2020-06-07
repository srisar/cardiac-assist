<?php


namespace App\Controllers\Visits;


use App\Core\App;
use App\Core\Requests\Request;
use App\Core\View;
use App\Models\Patient;
use App\Models\Visit;

class ViewsController
{

    public function viewAdd()
    {
        $patientId = Request::getAsInteger('patient_id');

        $patient = Patient::find($patientId);

        if ( $patient != null ) {
            View::setData('patient', $patient);
            View::render('visits/add.view');
            return;
        }

        App::redirect('/patients');
        return;

    }

    public function viewEdit()
    {

        $id = Request::getAsInteger('id');

        $visit = Visit::find($id);

        if ( !empty($visit) ) {


            App::setTitle('Visit');

            View::setData('visit', $visit);
            View::render('visits/edit.view');
            return;
        }

        App::redirect('/patients');
        return;

    }

}