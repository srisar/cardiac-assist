<?php

use App\Core\App;

?>

<div class="container-fluid mt-5 mb-3 d-print-none">
    <div class="row">
        <div class="col">

            <footer>
                <hr>
                <div class="text-center">
                    &copy; <?= date('Y') ?> Cardiac Clinic System. All rights reserved. Developed by <a href="https://srisar.dev">srisar.dev</a>.
                    <span class="badge badge-warning"><?= APP_VERSION ?></span>
                </div>
            </footer>

        </div>
    </div>
</div>


<script src="<?= App::siteURL() ?>/assets/js/jquery-3.5.1.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/popper.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/moment.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/daterangepicker-3.1/daterangepicker.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/ckeditor5/ckeditor.js"></script>
<script src="<?= App::siteURL() ?>/ckfinder/ckfinder.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/app.js"></script>
</body>
</html>

