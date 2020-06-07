<?php

use App\Core\App;
use App\Core\View;
use App\Models\Patient;

/** @var Patient $patient */
$patient = View::getData('patient');

?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

    <div id="view_add_visit"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 col-12">

                <div class="card">
                    <div class="card-header">Add a visit for <?= $patient->first_name ?></div>
                    <div class="card-body">

                        <input type="hidden" id="field_patient_id" value="<?= $patient->id ?>">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="field_visit_date">Visit date</label>
                                    <input type="text" class="form-control date_field" id="field_visit_date">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="field_remarks">Remarks</label>
                            <textarea id="field_remarks" rows="10" class="form-control"></textarea>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-success" id="btn_add_visit">Add</button>
                            <a href="<?= App::url('/patients/edit', ['id' => $patient->id]) ?>" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </div><!--.card-->


            </div>
        </div>
    </div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>