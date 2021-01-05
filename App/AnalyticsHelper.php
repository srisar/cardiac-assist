<?php


namespace App;


use App\Core\Database\Database;

class AnalyticsHelper
{

    public static function getBooksCount(): int
    {
        $db = Database::instance();
        $result = $db->query('select count(id) as total from books')->fetchObject('stdClass');
        return (int)$result->total;

    }

    public static function getSubjectsCount(): int
    {
        $db = Database::instance();
        $result = $db->query('select count(id) as total from subjects')->fetchObject('stdClass');
        return (int)$result->total;
    }

    public static function getSuppliersCount(): int
    {
        $db = Database::instance();
        $result = $db->query('select count(id) as total from suppliers')->fetchObject('stdClass');
        return (int)$result->total;

    }

}