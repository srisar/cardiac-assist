<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Patient;
use App\Models\Visit\Visit;
use App\Models\Visit\VisitPrescription;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );


try {

    $fields = [
        "patient_id" => Request::getAsInteger( "patient_id" ),
        "visit_date" => Request::getAsString( "visit_date" ),
        "remarks" => Request::getAsString( "remarks" ),

        "height" => Request::getAsFloat( "height" ),
        "weight" => Request::getAsFloat( "weight" ),

        "bmi" => Request::getAsFloat( "bmi" ),
        "bsa" => Request::getAsFloat( "bsa" ),
        "dbp" => Request::getAsFloat( "dbp" ),
        "sbp" => Request::getAsFloat( "sbp" ),
        "ef" => Request::getAsFloat( "ef" ),

        "dm" => Request::getAsBoolean( "dm" ),
        "ht" => Request::getAsBoolean( "ht" ),
        "dl" => Request::getAsBoolean( "dl" ),

        "heart_beat" => Request::getAsInteger( "heart_beat" ),
        "smoking" => Request::getAsString( "smoking" ),
        "family_history" => Request::getAsString( "family_history" ),
        "performed_by" => Request::getAsString( "performed_by" ),

    ];


    $object = Visit::build( $fields );

    /* add a visit details */
    $result = $object->insert();
    if ( empty( $result ) ) throw new Exception( "Failed" );

    /*
     * check if patient has any existing visits, if there are any,
     * then choose the latest one to get some of its data
     * and add them to the current visit.
     */
    $existingVisits = Visit::findByPatient( Patient::find( $fields[ 'patient_id' ] ) );

    if ( !empty( $existingVisits ) ) {
        $lastVisit = $existingVisits[ count( $existingVisits ) - 1 ];
        $previousVisit = $existingVisits[ count( $existingVisits ) - 2 ];

        /* previous visit prescriptions */
        $prescriptions = VisitPrescription::findByVisit( $previousVisit );

        if ( !empty( $prescriptions ) ) {
            foreach ( $prescriptions as $prescription ) {

                /* all current prescription items */
                $items = $prescription->prescription_items;

                /* creating new prescription into the latest visit */
                $id = $prescription->insertIntoVisit( $lastVisit, $lastVisit->visit_date );

                if ( !empty( $id ) ) {
                    $p = VisitPrescription::find( $id );

                    if ( !empty( $p ) ) {
                        if ( !empty( $items ) ) {
                            foreach ( $items as $item ) {
                                $item->insertIntoPrescription( $p );
                            }
                        }
                    }
                }

            }
        }

    }

    JSONResponse::validResponse();
    return;

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}
