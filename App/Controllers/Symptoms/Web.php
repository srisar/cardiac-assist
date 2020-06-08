<?php


namespace App\Controllers\Symptoms;


use App\Core\App;
use App\Core\View;

class Web
{
    public function viewManage()
    {

        App::setTitle('Manage Symptoms');
        View::render('symptoms/manage.view');

    }
}