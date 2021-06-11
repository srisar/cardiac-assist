<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;
use Exception;
use PDO;

class VisitPrescription implements IModel
{

    private const TABLE = "visit_prescriptions";

    public ?int $id, $visit_id;
    public ?string $remarks, $date;
    public ?array $prescription_items;


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
        /** @var self $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if (!empty($result)) {
            $result->prescription_items = VisitPrescriptionItem::findByPrescription($result);
            return $result;
        }

        return null;

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
            "date" => $this->date,
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            "remarks" => $this->remarks,
            "date" => $this->date,
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
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
