<?php

use App\Core\Authentication;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Models\Visit\VisitAngiography;

require_once "../../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect(DEBUG);

try {

    $fields = [
        "id" => Request::getAsInteger("id"),
        "instruments" => Request::getAsString("instruments"),
        "notes" => Request::getAsString("notes"),

        "dominance_left" => Request::getAsBoolean("dominance_left"),
        "dominance_right" => Request::getAsBoolean("dominance_right"),

        "prox_rca_stenosis" => Request::getAsInteger("prox_rca_stenosis"),
        "prox_rca_lesion_type" => Request::getAsString("prox_rca_lesion_type"),
        "prox_rca_timi_flow" => Request::getAsString("prox_rca_timi_flow"),

        "prox_lad_stenosis" => Request::getAsInteger("prox_lad_stenosis"),
        "prox_lad_lesion_type" => Request::getAsString("prox_lad_lesion_type"),
        "prox_lad_timi_flow" => Request::getAsString("prox_lad_timi_flow"),

        "mid_rca_stenosis" => Request::getAsInteger("mid_rca_stenosis"),
        "mid_rca_lesion_type" => Request::getAsString("mid_rca_lesion_type"),
        "mid_rca_timi_flow" => Request::getAsString("mid_rca_timi_flow"),

        "rpl1_stenosis" => Request::getAsInteger("rpl1_stenosis"),
        "rpl1_lesion_type" => Request::getAsString("rpl1_lesion_type"),
        "rpl1_timi_flow" => Request::getAsString("rpl1_timi_flow"),

        "rpl2_stenosis" => Request::getAsInteger("rpl2_stenosis"),
        "rpl2_lesion_type" => Request::getAsString("rpl2_lesion_type"),
        "rpl2_timi_flow" => Request::getAsString("rpl2_timi_flow"),

        "mid_lad_stenosis" => Request::getAsInteger("mid_lad_stenosis"),
        "mid_lad_lesion_type" => Request::getAsString("mid_lad_lesion_type"),
        "mid_lad_timi_flow" => Request::getAsString("mid_lad_timi_flow"),

        "dist_lad_stenosis" => Request::getAsInteger("dist_lad_stenosis"),
        "dist_lad_lesion_type" => Request::getAsString("dist_lad_lesion_type"),
        "dist_lad_timi_flow" => Request::getAsString("dist_lad_timi_flow"),

        "left_main_stenosis" => Request::getAsInteger("left_main_stenosis"),
        "left_main_lesion_type" => Request::getAsString("left_main_lesion_type"),
        "left_main_timi_flow" => Request::getAsString("left_main_timi_flow"),

        "left_circumflex_stenosis" => Request::getAsInteger("left_circumflex_stenosis"),
        "left_circumflex_lesion_type" => Request::getAsString("left_circumflex_lesion_type"),
        "left_circumflex_timi_flow" => Request::getAsString("left_circumflex_timi_flow"),

        "om1_stenosis" => Request::getAsInteger("om1_stenosis"),
        "om1_lesion_type" => Request::getAsString("om1_lesion_type"),
        "om1_timi_flow" => Request::getAsString("om1_timi_flow"),

        "om2_stenosis" => Request::getAsInteger("om2_stenosis"),
        "om2_lesion_type" => Request::getAsString("om2_lesion_type"),
        "om2_timi_flow" => Request::getAsString("om2_timi_flow"),

        "pda_stenosis" => Request::getAsInteger("pda_stenosis"),
        "pda_lesion_type" => Request::getAsString("pda_lesion_type"),
        "pda_timi_flow" => Request::getAsString("pda_timi_flow"),

    ];

//    __log($fields);


    if (empty($fields["id"])) throw new Exception("Invalid id");

    $object = VisitAngiography::build($fields);

    $result = $object->update();

    if (empty($result)) throw new Exception("Failed");

    JSONResponse::validResponse();

} catch (Exception $exception) {
    JSONResponse::exceptionResponse($exception);
}

