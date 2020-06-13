<?php

use App\Core\App;
use App\Core\Messages\SessionError;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= App::appName() ?> - Login</title>
    <link rel="stylesheet" href="<?= App::siteURL() ?>/css/app.css">

</head>
<body>

<div id="app">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">

                <div class="card">
                    <div class="card-header">Login to <?= App::appName() ?></div>
                    <div class="card-body">

                        <form @submit="tryLogin">

                            <div></div>

                            <div class="form-group">
                                <label for="field_username">Username</label>
                                <input v-model="username" type="text" class="form-control" id="field_username" :class="{'is-invalid' :forms.invalidUsername}">
                                <div class="invalid-feedback">Username cannot be empty.</div>
                            </div>

                            <div class="form-group">
                                <label for="field_password">Password</label>
                                <input v-model="password" type="password" class="form-control" id="field_password" :class="{'is-invalid' :forms.invalidPassword}">
                                <div class="invalid-feedback">Password cannot be empty</div>
                            </div>

                            <div class="text-center">
                                <button v-on:click="tryLogin" class="btn btn-primary" type="button" id="btn_login">Login</button>
                            </div>

                        </form>

                    </div>
                </div><!--.card-->

            </div><!--.col-->
        </div><!--.row-->
    </div><!--.container-->

</div>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="<?= App::siteURL() ?>/js/libs/all.js"></script>
<script src="<?= App::siteURL() ?>/js/app.js"></script>
<script><?php include_once "login.view.js" ?></script>
</body>
</html>