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


<!--
|
| modal: edit/delete symptom
|
-->

<div class="modal fade" id="modal_edit_symptom" tabindex="-1" role="dialog" aria-labelledby="modal_edit_symptom" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="label_edit_symptom_title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="field_edit_id" value="">

                <div class="form-group">
                    <label for="field_edit_symptom_name">Symptom name</label>
                    <input type="text" id="field_edit_symptom_name" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="field_edit_description">Description</label>
                    <textarea id="field_edit_description" rows="15" class="form-control"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_update_symptom">Update changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn_delete_symptom">Delete</button>
            </div>
        </div>
    </div>
</div>



<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>

<script>
    <?php include_once "manage_symptoms.js"; ?>
</script>