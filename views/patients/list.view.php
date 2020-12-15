<?php
use App\Core\App;
?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

<div id="app"></div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>

<script src="<?= App::siteURL() ?>/vue/patients/list/list-patients.js"></script>
