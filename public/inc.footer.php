<?php

use App\Core\App;

?>

<div class="container-fluid mt-5 mb-3">
    <div class="row">
        <div class="col">

            <footer>
                <hr>
                <div class="text-center">
                    &copy; <?= date('Y') ?> Cardiac Assist. All rights reserved. Developed by <a href="https://gravitide.dev">gravitide.dev</a>.
                    <span class="badge badge-warning"><?= APP_VERSION ?></span>
                </div>
            </footer>

        </div>
    </div>
</div>

<script src="<?= App::siteURL() ?>/assets/js/jquery-3.5.1.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/popper.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/bootstrap.bundle.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/moment.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/DataTables/datatables.min.js"></script>
<script src="<?= App::siteURL() ?>/assets/daterangepicker-3.1/daterangepicker.js"></script>
<script src="<?= App::siteURL() ?>/assets/ckeditor5/ckeditor.js"></script>
<script src="<?= App::siteURL() ?>/ckfinder/ckfinder.js"></script>
<script src="<?= App::siteURL() ?>/assets/js/app.js"></script>
</body>
</html>

