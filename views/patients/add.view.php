<?php

use App\Core\App;
use App\Core\Helpers\FormHelper;
use App\Models\Patient;


?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

    <div id="view_add_patient"></div>

    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12 col-lg-7">

                <div class="card card-collapsible mb-4" id="container_add_patient">

                    <div class="card-header">Add new patient</div>

                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="field_first_name" class="required">First name</label>
                                    <input class="form-control" type="text" id="field_first_name" required>
                                    <div class="invalid-feedback">First name is required.</div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="field_last_name" class="required">Last name</label>
                                    <input class="form-control" type="text" id="field_last_name" required>
                                    <div class="invalid-feedback">Last name is required.</div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="field_sex" class="required">Gender</label>
                                    <select name="" id="field_sex" class="form-control">
                                        <?php FormHelper::renderDropdownOptions(Patient::GENDER_LIST); ?>
                                    </select>
                                </div>
                            </div>

                        </div><!--.row-->

                        <div class="form-row">
                            <div class="col-sm-4 col-md-3">

                                <div class="form-group">
                                    <label for="field_nic">NIC</label>
                                    <input class="form-control" type="text" id="field_nic">

                                </div>


                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="field_dob">Date of birth</label>
                                    <input class="form-control date_field" type="text" id="field_dob" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="field_age">Age</label>
                                    <input class="form-control" type="number" id="field_age" value="0">

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="field_phone">Phone number</label>
                                    <input class="form-control" type="text" id="field_phone" value="">

                                </div>
                            </div>

                        </div><!--.row-->

                        <div class="row">


                        </div><!--.row-->

                        <div class="form-row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field_address">Address</label>
                                    <textarea class="form-control" name="field_address" id="field_address" rows="4"></textarea>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field_ds_division">DS division</label>
                                    <select name="" id="field_ds_division" class="form-control">
                                        <?php FormHelper::renderDropdownOptions(Patient::DS_DIVISION_LIST); ?>
                                    </select>

                                </div>
                            </div>
                        </div><!--.row-->

                        <div class="form-row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field_job">Job</label>
                                    <select name="" id="field_job" class="form-control">
                                        <?php FormHelper::renderDropdownOptions(Patient::JOB_LIST); ?>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field_job_type">Job type</label>
                                    <select name="" id="field_job_type" class="form-control">
                                        <?php FormHelper::renderDropdownOptions(Patient::JOB_TYPE_LIST); ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field_income">Monthly income</label>
                                    <input class="form-control" type="number" id="field_income" value="0">

                                </div>
                            </div>
                        </div><!--.row-->


                        <div class="text-right">
                            <button type="button" class="btn btn-success" id="btn_add_patient">Add Patient</button>
                            <a href="<?= App::url('/patients') ?>" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div> <!--.card-body-->
                </div><!--.card-->


            </div><!--end column-->

        </div>
    </div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>