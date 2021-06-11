<?php

use App\Core\App;
use App\Core\Authentication;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

App::setTitle("Manage Referral Letters");

?>

<?php include_once BASE_PATH . "/inc.header.php"; ?>

<div id="app"></div>

<?php include_once BASE_PATH . "/inc.footer.php"; ?>

<script src="manage.app.js"></script>
