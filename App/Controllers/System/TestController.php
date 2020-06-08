<?php


namespace App\Controllers\System;


use App\Core\Database\Database;
use App\Models\Visit;

class TestController
{

    public function genericTest()
    {

        Database::update('visits', ['visit_date' => '2020-05-05', 'remarks' => 'damn it!'], ['id' => 1]);

    }

}