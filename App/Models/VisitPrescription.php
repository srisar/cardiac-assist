<?php


namespace App\Models;


use App\Core\Database\Database;
use Exception;
use PDO;

class VisitPrescription implements IModel
{

    private const TABLE = "visit_prescriptions";

    public ?int $id, $visit_id;
    public ?string $remarks;


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
     * @return VisitPrescription|null
     */
    public static function find(int $id): ?VisitPrescription
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @throws Exception
     */
    public static function findAll($limit = 1000, $offset = 0)
    {
        throw new Exception("Not implemented");
    }


    public function insert(): int
    {
        $data = [
            "remarks" => $this->remarks,
            "visit_id" => $this->visit_id,
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            "remarks" => $this->remarks
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    public function delete()
    {
        /* before deleting the prescription,
        all drugs in the prescription must be deleted */
    }


    /**
     * @param Visit $visit
     * @return VisitPrescription[]
     */
    public static function findByVisit(Visit $visit): array
    {

        $db = Database::instance();
        $statement = $db->prepare("select * from visit_prescriptions where visit_id=?");
        $statement->execute([$visit->id]);

        /** @var self[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($result)) return $result;
        return [];

    }
}
