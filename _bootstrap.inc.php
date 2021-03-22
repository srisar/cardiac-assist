<?php

declare(strict_types=1);

session_start();

/**
 * Database config details
 */

require_once "vendor/autoload.php";

use App\Core\App;
use App\Core\Database\Database;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_config = [
    'HOST'     => $_ENV['DB_HOST'],
    'DATABASE' => $_ENV['DB_NAME'],
    'USERNAME' => $_ENV['DB_USERNAME'],
    'PASSWORD' => $_ENV['DB_PASSWORD'],
];


Database::init($db_config);

/**
 * Init global variables
 */

define('SITE_URL', 'http://localhost');
define('BASE_PATH', __DIR__ . '/public');
define('APP_NAME', $_ENV['APP_NAME']);
define('APP_VERSION', '0.9.1');


App::setTitle("");


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
