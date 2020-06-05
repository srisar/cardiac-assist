<?php

use App\Core\App;
use App\Core\Helpers\FormHelper;
use App\Models\Patient;


?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

    <div id="view_add_patient"></div>

    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">


                <table class="table table-bordered table-striped datatable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>One</td>
                        <td>One</td>
                    </tr>
                    <tr>
                        <td>Two</td>
                        <td>Two</td>
                    </tr>
                    </tbody>
                </table>



            </div><!--end column-->

        </div>
    </div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>