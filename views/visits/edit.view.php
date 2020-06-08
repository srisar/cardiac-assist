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

    <div id="view_edit_visit"></div>

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

                        <div class="form-group">
                            <label for="field_visit_symptom">Add a symptom</label>
                            <input type="text" class="form-control" id="field_visit_symptom">
                        </div>

                        <table class="table table-striped table-bordered datatable_simple" id="table_visit_symptoms">
                            <thead>
                            <tr>
                                <th>Symptom</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>

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

                        <input type="hidden" id="field_id" value="<?= $visit->id ?>">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="field_visit_date">Visit date</label>
                                    <input type="text" id="field_visit_date" class="form-control date_field" value="<?= $visit->visit_date ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field_remarks">Remarks</label>
                            <textarea id="field_remarks" class="form-control" rows="10"><?= $visit->remarks ?></textarea>
                        </div>

                        <div class="text-right">
                            <button id="btn_update_visit" class="btn btn-success">Update</button>
                        </div>

                    </div>
                </div><!--card-->

            </div><!--col-->


        </div><!--row-->

    </div><!--container-->

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>