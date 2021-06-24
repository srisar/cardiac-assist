<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitEchocardiography;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect( DEBUG );

try {

    $fields = [
        "id" => Request::getAsInteger( "id" ),

        "param_bp" => Request::getAsFloat( "param_bp" ),
        "param_cardiac_output" => Request::getAsFloat( "param_cardiac_output" ),
        "param_cardiac_index" => Request::getAsFloat( "param_cardiac_index" ),
        "param_dd_a" => Request::getAsFloat( "param_dd_a" ),
        "param_dd_e" => Request::getAsFloat( "param_dd_e" ),
        "param_dd_e_bar" => Request::getAsFloat( "param_dd_e_bar" ),
        "param_fractional_shortening" => Request::getAsFloat( "param_fractional_shortening" ),
        "param_hr" => Request::getAsFloat( "param_hr" ),
        "param_ivs_diastolic_thickness" => Request::getAsFloat( "param_ivs_diastolic_thickness" ),
        "param_lvef" => Request::getAsFloat( "param_lvef" ),
        "param_lvid_systole" => Request::getAsFloat( "param_lvid_systole" ),
        "param_lvid_diastole" => Request::getAsFloat( "param_lvid_diastole" ),
        "param_pw_diastolic_thickness" => Request::getAsFloat( "param_pw_diastolic_thickness" ),
        "param_stroke_volume" => Request::getAsFloat( "param_stroke_volume" ),


        "param_asd_size" => Request::getAsFloat( "param_asd_size" ),
        "param_la_area" => Request::getAsFloat( "param_la_area" ),
        "param_la_systolic_diameter" => Request::getAsFloat( "param_la_systolic_diameter" ),


        "param_doppler_mitral_valve_area" => Request::getAsFloat( "param_doppler_mitral_valve_area" ),
        "param_mean_mitral_gradient" => Request::getAsFloat( "param_mean_mitral_gradient" ),
        "param_mitral_pressure" => Request::getAsFloat( "param_mitral_pressure" ),
        "param_mv_score" => Request::getAsFloat( "param_mv_score" ),
        "param_trace_mitral_valve_area" => Request::getAsFloat( "param_trace_mitral_valve_area" ),


        "param_aortic_valve_area" => Request::getAsFloat( "param_aortic_valve_area" ),
        "param_aortic_lvot_velocity" => Request::getAsFloat( "param_aortic_lvot_velocity" ),
        "param_arpht" => Request::getAsFloat( "param_arpht" ),
        "param_lvot_diameter" => Request::getAsFloat( "param_lvot_diameter" ),
        "param_mean_aortic_gradient" => Request::getAsFloat( "param_mean_aortic_gradient" ),
        "param_peak_aortic_gradient" => Request::getAsFloat( "param_peak_aortic_gradient" ),
        "param_peak_aortic_velocity" => Request::getAsFloat( "param_peak_aortic_velocity" ),
        "param_peak_lvot_velocity" => Request::getAsFloat( "param_peak_lvot_velocity" ),


        "param_aortic_root_diameter" => Request::getAsFloat( "param_aortic_root_diameter" ),
        "param_aorta_root" => Request::getAsFloat( "param_aorta_root" ),
        "param_aorta_annulus" => Request::getAsFloat( "param_aorta_annulus" ),
        "param_aorta_st_junction" => Request::getAsFloat( "param_aorta_st_junction" ),
        "param_aorta_proximal" => Request::getAsFloat( "param_aorta_proximal" ),
        "param_aorta_aortic_arch" => Request::getAsFloat( "param_aorta_aortic_arch" ),

        "param_est_rvsp" => Request::getAsFloat( "param_est_rvsp" ),
        "param_est_cvp" => Request::getAsFloat( "param_est_cvp" ),
        "param_est_pasp" => Request::getAsFloat( "param_est_pasp" ),
        "param_mpa" => Request::getAsFloat( "param_mpa" ),
        "param_peak_tricuspid_velocity" => Request::getAsFloat( "param_peak_tricuspid_velocity" ),
        "param_rvid" => Request::getAsFloat( "param_rvid" ),
        "param_rvot1" => Request::getAsFloat( "param_rvot1" ),
        "param_rvot2" => Request::getAsFloat( "param_rvot2" ),
        "param_rvotat" => Request::getAsFloat( "param_rvotat" ),
        "param_rv_size" => Request::getAsFloat( "param_rv_size" ),
        "param_rv_ivg" => Request::getAsFloat( "param_rv_ivg" ),
        "param_tapse" => Request::getAsFloat( "param_tapse" ),

        "param_pv_pg" => Request::getAsFloat( "param_pv_pg" ),
        "param_pv_annulus" => Request::getAsFloat( "param_pv_annulus" ),

        "show_advanced" => Request::getAsBoolean( "show_advanced" ),
        "has_diastolic_dysfunction" => Request::getAsBoolean( "has_diastolic_dysfunction" ),
        "is_left_atrium_dilated" => Request::getAsBoolean( "is_left_atrium_dilated" ),
        "has_asd" => Request::getAsBoolean( "has_asd" ),
        "has_mitral_stenosis" => Request::getAsBoolean( "has_mitral_stenosis" ),
        "is_diseased_aortic_valve" => Request::getAsBoolean( "is_diseased_aortic_valve" ),
        "is_diseased_aorta" => Request::getAsBoolean( "is_diseased_aorta" ),
        "has_vsd" => Request::getAsBoolean( "has_vsd" ),
        "has_ps" => Request::getAsBoolean( "has_ps" ),


    ];

//    JSONResponse::invalidResponse($fields);
//    return;

    if ( empty( $fields["id"] ) ) throw new Exception( "Invalid id" );

    $object = VisitEchocardiography::build( $fields );

    $result = $object->update();

    if ( empty( $result ) ) throw new Exception( "Failed" );

    JSONResponse::validResponse();

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse( $exception );
}

