<?php

/**
 * View: Manage symptoms
 * Controller: Symptoms\SymptomsController
 */

use App\Core\App;
use App\Core\Helpers\FormHelper;

?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

<div id="view_add_symptom"></div>

<div class="container-fluid">

    <div class="row justify-content-center">

        <!--
        |
        | start section: add a symptom
        |
        -->
        <div class="col-12 col-lg-4">

            <div class="card" id="form_add_symptom">
                <div class="card-header">Add a symptom</div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="field_symptom_name">Symptom name <?= FormHelper::required() ?></label>
                        <input type="text" id="field_symptom_name" class="form-control" value="" required>
                        <div class="invalid-feedback">Symptom name is required.</div>
                    </div>

                    <div class="form-group">
                        <label for="field_description">Description</label>
                        <textarea id="field_description" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="text-right">
                        <button id="btn_add_symptom" class="btn btn-success">Add symptom</button>
                    </div>

                </div>
            </div><!--card-->

        </div><!--col-->

        <!--
        |
        | start section: add a symptom
        |
        -->
        <div class="col-12 col-lg-8">

            <div class="card">
                <div class="card-header">Existing symptoms</div>
                <div class="card-body">

                    <table class="table table-bordered table-striped datatable_simple" id="table_symptoms">
                        <thead>
                        <tr>
                            <th>Symptom</th>
                            <th>Description</th>
                        </tr>
                        </thead>



                    </table>

                </div>
            </div>

        </div><!--col-->

    </div><!--row-->

</div><!--container-->

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>

