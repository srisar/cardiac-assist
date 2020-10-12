<?php

/**
 * View: Add a new visit
 */

use App\Core\App;
use App\Core\View;
use App\Models\Patient;

/** @var Patient $patient */
$patient = View::getData('patient');

?>
<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

<section id="php_values">
  <input type="hidden" id="patient_name" value="<?= $patient->first_name ?>">
  <input type="hidden" id="patient_id" value="<?= $patient->id ?>">
</section>

<div id="app_add_visit"></div>

<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>

<script src="<?= App::siteURL() ?>/vue/visits/add/add_visit.js"></script>