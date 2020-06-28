<?php


namespace App\Controllers;


use App\Core\App;
use App\Core\Sessions\AuthSession;
use App\Core\View;

class PagesController
{

    public function index()
    {

        if(!AuthSession::validate()){
            App::redirect('/login');
        }

        View::render("index.view");
    }

}