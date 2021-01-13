<?php

use App\Core\App;
use App\Core\Authentication;
use App\Core\Requests\Request;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

App::setTitle("View Visit");

/*
 * Check if id is available
 * */
$id = Request::getAsInteger('id');
if(empty($id)) App::redirect('/app/patients/list.php');

?>

<?php include_once BASE_PATH . "/inc.header.php"; ?>

<input type="hidden" value="<?= $id ?>" id="php_visit_id">

<div id="app"></div>

<?php include_once BASE_PATH . "/inc.footer.php"; ?>

<script src="manage.app.js"></script>

