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

    <link rel="apple-touch-icon" sizes="57x57" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= App::siteURL() ?>/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= App::siteURL() ?>/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= App::siteURL() ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= App::siteURL() ?>/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= App::siteURL() ?>/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= App::siteURL() ?>/assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700&display=swap" rel="stylesheet">
    <!-- google fonts -->

    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/fonts/clear-sans/stylesheet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/daterangepicker-3.1/daterangepicker.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/css/app.css">

</head>
<body>


<?php if (Authentication::isAuthenticated() || Authentication::isAuthenticated(User::ROLE_ADMIN) || Authentication::isAuthenticated(User::ROLE_MANAGER)): ?>
    <!-- TOP NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">

        <a class="navbar-brand" href="<?= App::siteURL() ?>">
            <img class="img-fluid" style="width: 30px" src="<?= App::siteURL() ?>/assets/images/app-icon.svg" alt="Bookstore management system">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= App::siteURL() ?>">Home</a>
                </li>


                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Patients
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/patients/add.php">Add a patient</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/patients/list.php">View all patients</a>
                    </div>
                </li><!-- end nav-item -->

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/symptoms/manage.php">Symptoms</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/diseases/manage.php">Diseases</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/problems/manage.php">Problems</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/investigations/manage.php">Investigations</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/drugs/manage.php">Drugs</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/referral-letters/manage.php">Referral Letters</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/remarks.php">Echo remarks</a>
                    </div>
                </li><!-- end nav-item -->


            </ul>

            <div>
                <a href="<?= App::url('/app/users/manage.php') ?>" class="btn btn-sm btn-success"><i class="bi bi-people-fill"></i> Manage Users</a>
                <a href="<?= App::url('/logout.php') ?>" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>

        </div>


    </nav>

<?php endif; ?>

