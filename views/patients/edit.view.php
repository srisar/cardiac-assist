<?php

use App\Core\App;
use App\Core\Helpers\FormHelper;
use App\Core\View;
use App\Models\Patient;

/** @var Patient $patient */
$patient = View::getData("patient");

?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

<div id="view_edit_patient"></div>

<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12 col-lg-7">

            <div class="card card-collapsible mb-4" id="container_add_patient">

                <div class="card-header">Edit patient</div>

                <div class="card-body">

                    <input type="hidden" id="field_id" value="<?= $patient->id ?>">

                    <div class="form-row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="field_first_name" class="">First name <?= FormHelper::required() ?></label>
                                <input class="form-control" type="text" id="field_first_name" required value="<?= $patient->first_name ?>">
                                <div class="invalid-feedback">First name is required.</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field_last_name" class="">Last name <?= FormHelper::required() ?></label>
                                <input class="form-control" type="text" id="field_last_name" required value="<?= $patient->last_name ?>">
                                <div class="invalid-feedback">Last name is required.</div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field_sex" class="">Gender <?= FormHelper::required() ?></label>
                                <select name="" id="field_sex" class="form-control">
                                    <?php FormHelper::renderDropdownOptions(Patient::GENDER_LIST, $patient->gender); ?>
                                </select>
                            </div>
                        </div>

                    </div><!--.row-->

                    <div class="form-row">
                        <div class="col-sm-4 col-md-3">

                            <div class="form-group">
                                <label for="field_nic">NIC</label>
                                <input class="form-control" type="text" id="field_nic" value="<?= $patient->nic ?>">

                            </div>


                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field_dob">Date of birth</label>
                                <input class="form-control date_field" type="text" id="field_dob" required value="<?= $patient->dob ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field_age">Age</label>
                                <input class="form-control" type="number" id="field_age" value="<?= $patient->age ?>">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field_phone">Phone number</label>
                                <input class="form-control" type="text" id="field_phone" value="<?= $patient->phone ?>">

                            </div>
                        </div>

                    </div><!--.row-->


                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_address">Address</label>
                                <textarea class="form-control" name="field_address" id="field_address" rows="4"><?= $patient->address ?></textarea>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_ds_division">DS division</label>
                                <select name="" id="field_ds_division" class="form-control">
                                    <?php FormHelper::renderDropdownOptions(Patient::DS_DIVISION_LIST, $patient->ds_division); ?>
                                </select>

                            </div>
                        </div>
                    </div><!--.row-->

                    <div class="form-row">


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field_job">Job</label>
                                <select name="" id="field_job" class="form-control">
                                    <?php FormHelper::renderDropdownOptions(Patient::JOB_LIST, $patient->job); ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field_job_type">Job type</label>
                                <select name="" id="field_job_type" class="form-control">
                                    <?php FormHelper::renderDropdownOptions(Patient::JOB_TYPE_LIST, $patient->job_type); ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field_income">Monthly income</label>
                                <input class="form-control" type="number" id="field_income" value="<?= $patient->income ?>">

                            </div>
                        </div>
                    </div><!--.row-->


                    <div class="text-right">
                        <button type="button" class="btn btn-success" id="btn_update_patient">Update Patient</button>
                        <a href="<?= App::url('/patients') ?>" class="btn btn-secondary">Cancel</a>
                        <hr>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group text-center">
                                <label for="field_status">STATUS</label>
                                <select name="" id="field_status" class="form-control">
                                    <?php FormHelper::renderDropdownOptions(Patient::STATUS_LIST, $patient->status); ?>
                                </select>

                            </div>
                        </div>
                    </div>


                </div> <!--.card-body-->
            </div><!--.card-->


        </div><!--end column-->

    </div>
</div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>
