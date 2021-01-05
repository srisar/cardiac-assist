<?php

use App\Core\App;

include_once "../_bootstrap.inc.php";


session_unset();
session_destroy();

App::redirect('/');