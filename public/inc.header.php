<?php

use App\Core\App;
use App\Core\Authentication;
use App\Models\User;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= App::getTitle() ?></title>

    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/bs-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/css/app.css">

</head>
<body>


<?php if ( Authentication::isAuthenticated() || Authentication::isAuthenticated(User::ROLE_ADMIN) || Authentication::isAuthenticated(User::ROLE_MANAGER) ): ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">

        <a class="navbar-brand" href="<?= App::siteURL() ?>">
            <img class="img-fluid" style="width: 30px" src="<?= App::siteURL() ?>/assets/images/app-icon.svg" alt="Bookstore management system">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= App::siteURL() ?>">Home</a>
                </li>


                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Suppliers
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::url('/bookstore/supplier/manage.php') ?>">Manage suppliers</a>
                        <a class="dropdown-item" href="<?= App::url('/bookstore/supplier/add.php') ?>">Add a supplier</a>

                    </div>
                </li><!-- end nav-item -->

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Books
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/bookstore/books/manage.php">Manage books</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/bookstore/subjects/manage.php">Manage subjects</a>

                    </div>
                </li><!-- end nav-item -->


                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Purchases
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::url('/bookstore/books-purchase/add.php') ?>">Add a new book purchase</a>
                        <a class="dropdown-item" href="<?= App::url('/bookstore/books-purchase/view-all.php') ?>">View purchases</a>

                    </div>
                </li><!-- end nav-item -->


            </ul>

            <div>
                <a href="<?= App::url('/bookstore/users/manage.php') ?>" class="btn btn-sm btn-success"><i class="bi bi-people-fill"></i> Manage Users</a>
                <a href="<?= App::url('/logout.php') ?>" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>

        </div>


    </nav>

<?php endif; ?>

