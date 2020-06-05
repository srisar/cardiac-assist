<?php


namespace App\Controllers\Patients;


use App\Core\View;

class PatientsController
{

    public function viewAdd()
    {

        View::render("patients/add.view");

    }

}