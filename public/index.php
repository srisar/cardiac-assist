<?php


use App\Core\App;
use App\Core\Authentication;

require_once "../_bootstrap.inc.php";

// is user logged in
Authentication::isUserOrRedirect();


App::setTitle("Home");

?>

<?php include_once BASE_PATH . "/inc.header.php"; ?>

<div id="app"></div>

<?php include_once BASE_PATH . "/inc.footer.php"; ?>
<script src="app/homepage/home.app.js"></script>

