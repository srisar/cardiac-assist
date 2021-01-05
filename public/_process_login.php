<?php


/*
 * to stop anyone from directly looking at this page
 * */

if ( !isset($_POST['from_login']) ) header("Location: index.php");


use App\Core\App;
use App\Core\Authentication;

include_once "../_bootstrap.inc.php";


$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ( Authentication::authenticate($username, $password) ) {
    App::redirect('/');
} else {
    App::redirect('/login.php?error=1');
}