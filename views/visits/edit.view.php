<?php

/**
 * View:
 * Controller:
 */

use App\Core\App;
use App\Core\View;
use App\Models\Visit;

/** @var Visit $visit */
$visit = View::getData('visit');


?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

<input type="hidden" id="id_visit" value="<?= $visit->id; ?>">

<div class="container-fluid">

    <div class="row justify-content-center">

        <!--
        |
        | start section: visit symptoms
        |
        -->

        <div class="col-12 col-lg-8">

            <div class="card" id="form_visit_symptoms">
                <div class="card-header">Symptoms</div>
                <div class="card-body">

                    <div id="vue_manage_visit_symptoms"></div>

                </div>
            </div>

        </div>

        <!--
        |
        | start section: visit details
        |
        -->

        <div class="col-12 col-lg-4">

            <div class="card" id="form_visit_details">
                <div class="card-header">Visit details</div>
                <div class="card-body">

                    <div id="vue_manage_visit"></div>

                </div>
            </div><!--card-->

        </div><!--col-->


    </div><!--row-->

</div><!--container-->



<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>

<script src="<?php App::siteURL() ?>/vue/visits/manage_visit.js"></script>
