<?php

include_once "../_bootstrap.inc.php";


$hashed_password = password_hash('admin', PASSWORD_DEFAULT);
var_dump($hashed_password);

var_dump(password_verify('admin', $hashed_password));