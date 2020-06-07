<?php


namespace App\Controllers\System;


use App\Models\Visit;

class TestController
{

    public function genericTest()
    {
        var_dump("hello! this is a test.");

        $visit = Visit::build([
            'patient_id' => 1,
            'remarks' => 'What a remark!',
            'visit_date' => '2020-06-02'
        ]);

        var_dump($visit->insert());

    }

}