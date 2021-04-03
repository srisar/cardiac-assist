<?php


namespace App\Core\Requests;


use Exception;

class Request
{

    public const REQUEST_GET = 'GET';
    public const REQUEST_POST = 'POST';

    /**
     * Returns the request method: GET, POST, PUT, DELETE and so on..
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function scheme()
    {
        return $_SERVER['REQUEST_SCHEME'];
    }

    public static function host()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /*
     * ---------------------------------------------------------------------------------------
     * | Request parameters from GET/POST
     * ---------------------------------------------------------------------------------------
     */
    /**
     * @param string $key
     * @return string
     */
    private static function getParam(string $key): ?string
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        return null;
    }

    /**
     * Returns request parameter value as integer
     * @param string $key
     * @return int|null
     */
    public static function getAsInteger(string $key): ?int
    {
        $data = self::getParam($key);

        if (!is_null($data)) {
            if ($data == '0') return 0;
            if (filter_var($data, FILTER_VALIDATE_INT)) {
                return (int)$data;
            }
        }
        return null;
    }

    /**
     * Returns request parameter value as float
     * @param string $key
     * @return float|null
     */
    public static function getAsFloat(string $key): ?float
    {
        $data = self::getParam($key);

        if (!is_null($data)) {

            if ($data == '0') return 0;

            return filter_var($data, FILTER_VALIDATE_FLOAT);
        }
        return null;
    }

    /**
     * Returns request parameter value as string
     * @param string $key
     * @return string|null
     */
    public static function getAsString(string $key): ?string
    {
        $data = self::getParam($key);
        if (!is_null($data)) {
            return filter_var($data, FILTER_SANITIZE_STRING);
        }
        return null;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function getAsRawString(string $key): ?string
    {
        return self::getParam($key);
    }

    /**
     * @param string $key
     * @return bool|null
     * @throws Exception
     */
    public static function getAsBoolean(string $key): ?bool
    {
        $data = self::getParam($key);
        if (!is_null($data)) {
            return filter_var($data, FILTER_VALIDATE_BOOLEAN);
        }

        throw new Exception('Invalid boolean value');
    }


    public static function cors()
    {

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }

    }

}
