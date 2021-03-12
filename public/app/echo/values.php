<?php

use App\Core\App;
use App\Core\Authentication;
use App\Core\Requests\Request;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

App::setTitle("Mitral Valve Values");

?>

<?php include_once BASE_PATH . "/inc.header.php"; ?>

<div id="app"></div>

<?php include_once BASE_PATH . "/inc.footer.php"; ?>

<script src="values.app.js"></script>

