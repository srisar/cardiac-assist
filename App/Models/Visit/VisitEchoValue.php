<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\EchoRemarks;
use App\Models\IModel;
use PDO;

class VisitEchoValue implements IModel
{

    private const TABLE = "visit_echo_values";

    public ?int $id, $visit_id, $echo_value_id;

    public ?EchoRemarks $echoValue;

    public const TYPE_AORTA = "AORTA";
    public const TYPE_AORTIC_VALVE = "AORTIC_VALVE";
    public const TYPE_DOPPLER = "DOPPLER";
    public const TYPE_LEFT_ATRIUM = "LEFT_ATRIUM";
    public const TYPE_MITRAL_VALVE = "MITRAL_VALVE";
    public const TYPE_PERICARDIUM = "PERICARDIUM";
    public const TYPE_PULMONIC_VALVE = "PULMONIC_VALVE";
    public const TYPE_RIGHT_ATRIUM = "RIGHT_ATRIUM";
    public const TYPE_RIGHT_VENTRICLE = "RIGHT_VENTRICLE";
    public const TYPE_TRICUSPID = "TRICUSPID";


    public static function build($array): self
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return VisitEchoValue
     */
    public static function find(int $id): VisitEchoValue
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    public static function findAll($limit = 1000, $offset = 0)
    {

    }

    public function insert(): int
    {
        $data = [
            "visit_id" => $this->visit_id,
            "echo_value_id" => $this->echo_value_id,
        ];

        return Database::insert(self::TABLE, $data);

    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }


    /**
     * @param Visit $visit
     * @return VisitEchoValue[]
     */
    public static function findByVisit(Visit $visit): array
    {

        $db = Database::instance();
        $statement = $db->prepare("select * from visit_echo_values where visit_id=?");
        $statement->execute([$visit->id]);

        /** @var VisitEchoValue[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($result)) return $result;
        return [];

    }

    /**
     * @param Visit $visit
     * @param string $type
     * @return VisitEchoValue[]
     */
    public static function findByVisitAndType(Visit $visit, string $type): array
    {
        $db = Database::instance();

        $statement = $db->prepare("select v.id, v.visit_id, v.echo_value_id, e.type, e.value from visit_echo_values v 
                                        inner join echo_remarks e 
                                        on v.echo_value_id = e.id
                                        where visit_id=? and type=?");

        $statement->execute([$visit->id, $type]);

        /** @var VisitEchoValue[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($result)) {

            $output = [];
            foreach ($result as $visitEchoValue) {
//                $visitEchoValue->echoValue = EchoRemarks::find($visitEchoValue->echo_value_id);
                $output[] = $visitEchoValue;
            }

            return $output;

        }

        return [];
    }

}
