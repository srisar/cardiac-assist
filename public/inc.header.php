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
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/fonts/clear-sans/stylesheet.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/bs-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/daterangepicker-3.1/daterangepicker.css">
    <link rel="stylesheet" href="<?= App::siteURL() ?>/assets/css/app.css">

</head>
<body>


<?php if ( Authentication::isAuthenticated() || Authentication::isAuthenticated(User::ROLE_ADMIN) || Authentication::isAuthenticated(User::ROLE_MANAGER) ): ?>
    <!-- TOP NAVIGATION BAR -->
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
                        Patients
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/patients/add.php">Add a patient</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/patients/list.php">View all patients</a>
                    </div>
                </li><!-- end nav-item -->

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/symptoms/manage.php">Symptoms</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/diseases/manage.php">Diseases</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/investigations/manage.php">Investigations</a>
                    </div>
                </li><!-- end nav-item -->

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Echocardiography
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#mitral">Mitral Valve Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#aortic">Aortic Valve Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#pulmonic">Pulmonic Valve Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#tricuspid">Tricuspid Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#aorta">Aorta Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#left-atrium">Left atrium Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#right-atrium">Right atrium Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#left-ventricle">Left Ventricle Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#right-ventricle">Right Ventricle Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#pericardium">Pericardium Values</a>
                        <a class="dropdown-item" href="<?= App::siteURL() ?>/app/echo/values.php#doppler">Doppler Values</a>
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

