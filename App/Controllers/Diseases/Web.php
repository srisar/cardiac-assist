<?php


namespace App\Controllers\Diseases;


use App\Core\App;
use App\Core\View;

class Web
{

    public function manage()
    {
        App::setTitle('Manage Diseases');
        View::render('diseases/manage.view');
    }

}