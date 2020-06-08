<?php


namespace App\Core\Requests;


class Axios
{

    /**
     * The method returns a request sent by axios js library.
     * @return array
     */
    public static function get()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if ( !empty($data) ) {
            $_REQUEST = $data;
            return $data;
        }

        return $data;
    }

}