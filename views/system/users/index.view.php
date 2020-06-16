<?php

use App\Core\App;
use App\Core\View;
use App\Models\User;

/** @var User[] $users */
$users = View::getData('users');

?>

<?php include_once BASE_PATH . '/views/_header.inc.php'; ?>

<div id="app"></div>


<?php include_once BASE_PATH . '/views/_footer.inc.php'; ?>
<script src="<?php App::siteURL() ?>/vue/system/users/manage_users.js"></script>