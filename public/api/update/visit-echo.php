<?php

use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\VisitEchocardiography;

require_once "../../../_bootstrap.inc.php";

try {

    $fields = [
        'id'                            => Request::getAsInteger('id'),
        'param_la_systolic_diameter'    => Request::getAsFloat('param_la_systolic_diameter'),
        'param_aortic_root_diameter'    => Request::getAsFloat('param_aortic_root_diameter'),
        'param_lvot_diameter'           => Request::getAsFloat('param_lvot_diameter'),
        'param_ivs_diastolic_thickness' => Request::getAsFloat('param_ivs_diastolic_thickness'),
        'param_pw_diastolic_thickness'  => Request::getAsFloat('param_pw_diastolic_thickness'),
        'param_lvid_diastole'           => Request::getAsFloat('param_lvid_diastole'),
        'param_lvid_systole'            => Request::getAsFloat('param_lvid_systole'),
        'param_fractional_shortening'   => Request::getAsFloat('param_fractional_shortening'),
        'param_lvef'                    => Request::getAsFloat('param_lvef'),
        'param_rvid'                    => Request::getAsFloat('param_rvid'),
        'param_peak_aortic_velocity'    => Request::getAsFloat('param_peak_aortic_velocity'),
        'param_peak_lvot_velocity'      => Request::getAsFloat('param_peak_lvot_velocity'),
        'param_aortic_lvot_velocity'    => Request::getAsFloat('param_aortic_lvot_velocity'),
        'param_peak_aortic_gradient'    => Request::getAsFloat('param_peak_aortic_gradient'),
        'param_mean_aortic_gradient'    => Request::getAsFloat('param_mean_aortic_gradient'),
        'param_aortic_valve_area'       => Request::getAsFloat('param_aortic_valve_area'),
        'param_mitral_pressure'         => Request::getAsFloat('param_mitral_pressure'),
        'param_mean_mitral_gradient'    => Request::getAsFloat('param_mean_mitral_gradient'),
        'param_mitral_valve_area'       => Request::getAsFloat('param_mitral_valve_area'),
        'param_peak_tricuspid_velocity' => Request::getAsFloat('param_peak_tricuspid_velocity'),
        'param_stroke_volume'           => Request::getAsFloat('param_stroke_volume'),
        'param_cardiac_output'          => Request::getAsFloat('param_cardiac_output'),
        'param_cardiac_index'           => Request::getAsFloat('param_cardiac_index'),
        'param_bp'                      => Request::getAsFloat('param_bp'),
        'param_hr'                      => Request::getAsFloat('param_hr'),
        'param_est_rvsp'                => Request::getAsFloat('param_est_rvsp'),
        'param_est_cvp'                 => Request::getAsFloat('param_est_cvp'),
        'param_est_pasp'                => Request::getAsFloat('param_est_pasp'),
    ];

    if ( empty($fields['id']) ) throw new Exception('Invalid id');

    $object = VisitEchocardiography::build($fields);

    $result = $object->update();

    if ( empty($result) ) throw new Exception('Failed');

    JSONResponse::validResponse();

} catch ( Exception $exception ) {
    JSONResponse::exceptionResponse($exception);
}

