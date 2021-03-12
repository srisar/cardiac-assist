<?php


namespace App\Models;


use App\Core\Database\Database;

class VisitEchoReportValues
{

    public ?int $visit_id, $value_id;
    public ?string         $value;

    public static function findAllByVisit(Visit $visit, string $reportType): array
    {
        $db = Database::instance();

        $visitTable = "visit_" . $reportType;

        $statement = $db->prepare("SELECT e.id, e.value, v.visit_id FROM {$visitTable} v
                                    INNER JOIN {$reportType} e
                                    ON v.value_id = e.id where v.visit_id=?");

        $statement->execute([$visit->id]);
        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);

    }

    public static function insert($visit_id, $value_id, $report_type): bool
    {
        $db = Database::instance();

        $table = "visit_" . $report_type;

        $statement = $db->prepare("insert into {$table}(visit_id, value_id) values(?,?)");
        return $statement->execute([$visit_id, $value_id]);
    }

    public static function delete($visit_id, $value_id, $report_type): bool
    {
        $db = Database::instance();

        $table = "visit_" . $report_type;

        $statement = $db->prepare("delete from {$table} where visit_id=? and value_id=?");
        return $statement->execute([$visit_id, $value_id]);
    }

}
