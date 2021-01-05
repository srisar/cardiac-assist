<?php

use App\Core\App;
use App\Core\Authentication;
use App\Core\Requests\Request;

require_once "../../../_bootstrap.inc.php";

Authentication::isAdminOrRedirect();

App::setTitle("Edit Supplier");

$id = Request::getAsInteger('id');

if ( empty($id) ) App::redirect('/bookstore/supplier/manage.php');

?>

<?php include_once BASE_PATH . "/inc.header.php"; ?>

<input type="hidden" id="supplier-id" value="<?= $id ?>">

<div id="app"></div>

<?php include_once BASE_PATH . "/inc.footer.php"; ?>

<script src="edit-supplier.js"></script>