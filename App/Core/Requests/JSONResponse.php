<?php


namespace App\Core\Requests;


use Exception;

class JSONResponse
{

    private array $payload;
    private int $statusCode;


    public function __construct($data, $statusCode = 200)
    {
        $this->payload = $data;
        $this->statusCode = $statusCode;
    }

    public function response()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Origin, Methods");

        http_response_code($this->statusCode);
        echo json_encode($this->payload);
    }

    /**
     * response with invalid message
     * @param string|array $payload - by default, string, if array then
     * it is passed as raw
     */
    public static function invalidResponse($payload = 'Invalid request')
    {
        if ( !is_array($payload) ) {
            $response = new JSONResponse(['message' => $payload], 400);
        } else {
            $response = new JSONResponse($payload, 400);
        }

        $response->response();
    }


    /**
     * Response for exception handling
     * @param Exception $exception
     */
    public static function exceptionResponse(Exception $exception)
    {
        self::invalidResponse(['message' => $exception->getMessage()]);
    }

    public static function validResponse($payload = 'Success')
    {
        if ( !is_array($payload) ) {
            $response = new JSONResponse(['message' => $payload], 200);
        } else {
            $response = new JSONResponse($payload, 200);
        }

        $response->response();
    }

}