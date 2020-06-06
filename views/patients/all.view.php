<?php
use App\Core\App;
use App\Core\Helpers\FormHelper;
use App\Models\Patient;

?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

    <div id="view_all_patient"></div>

    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">


                <table class="table table-bordered table-striped" id="table_all_patients">
                    <thead>
                    <tr>
                        <th>Full name</th>
                        <th>Gender</th>
                        <th>Date of birth</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Job</th>
                        <th>Job type</th>
                        <th>Income</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>



            </div><!--end column-->

        </div>
    </div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>