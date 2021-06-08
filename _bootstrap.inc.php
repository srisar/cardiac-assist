<?php

declare(strict_types=1);

session_start();

/**
 * Database config details
 */

require_once "vendor/autoload.php";

use App\Core\App;
use App\Core\Database\Database;
use App\Core\Requests\Request;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_ENV["DEBUG"])) {

    if ($_ENV["DEBUG"] == "true") define("DEBUG", true);
    else define("DEBUG", false);
} else {
    define("DEBUG", false);
}

$db_config = [
    'HOST' => $_ENV['DB_HOST'],
    'DATABASE' => $_ENV['DB_NAME'],
    'USERNAME' => $_ENV['DB_USERNAME'],
    'PASSWORD' => $_ENV['DB_PASSWORD'],
];


Database::init($db_config);

/**
 * Init global variables
 */

const SITE_URL = 'http://localhost';
const BASE_PATH = __DIR__ . '/public';
define('APP_NAME', $_ENV['APP_NAME']);
const APP_VERSION = '0.10.5';


App::setTitle("");


Request::cors();

/*
 * HELPER FUNCTIONS
 */

/**
 * Logs data value into php error log file.
 * @param $data
 */
function __log($data)
{
    // https://gist.github.com/mkolb/2379498

    ob_start();
    print_r($data);
    error_log(ob_get_clean());
}
