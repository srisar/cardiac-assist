<?php

use App\Core\App;
use App\Core\Authentication;

require_once "../_bootstrap.inc.php";
if ( Authentication::isAuthenticated() ) App::redirect('/');
App::setTitle("Login");

$errors = $_GET['error'] ?? null;

?>


<?php include_once BASE_PATH . "/inc.header.php"; ?>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-12 col-md-4">

            <div class="alert alert-success">

                <h4><?= APP_NAME ?> : Login</h4>
                <hr>

                <?php if(!empty($errors)): ?>
                <div class="alert alert-danger">
                    Username or password incorrect!
                </div>
                <?php endif; ?>

                <form action="_process_login.php" method="post">

                    <input type="hidden" name="from_login">

                    <div class="form-group">
                        <label for="field_username">Username</label>
                        <input type="text" id="field_username" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="field_password">Password</label>
                        <input type="password" id="field_password" name="password" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-success">Login</button>
                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<?php include_once BASE_PATH . "/inc.footer.php"; ?>

