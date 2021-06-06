<?php


namespace App\Models;


use App\Core\Database\Database;
use Exception;
use PDO;

class VisitPrescriptionItem implements IModel
{

    private const TABLE = "visit_prescription_items";

    public ?int $id, $prescription_id, $drug_id;
    public ?string $dose, $frequency, $duration, $remarks;

    public ?VisitPrescription $prescription;
    public ?Drug $drug;

    /**
     * @param $array
     * @return static
     */
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
     * @return static|null
     */
    public static function find(int $id): ?self
    {
        /** @var self $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if (!empty($result)) {

//            $result->prescription = VisitPrescription::find($result->prescription_id);
            $result->drug = Drug::find($result->drug_id);

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
            "prescription_id" => $this->prescription_id,
            "drug_id" => $this->drug_id,
            "dose" => $this->dose,
            "frequency" => $this->frequency,
            "duration" => $this->duration,
            "remarks" => $this->remarks,
        ];

        return Database::insert(self::TABLE, $data);

    }

    public function update(): bool
    {
        $data = [
            "dose" => $this->dose,
            "frequency" => $this->frequency,
            "duration" => $this->duration,
            "remarks" => $this->remarks,
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }


    /**
     * @param VisitPrescription $prescription
     * @return self[]
     */
    public static function findByPrescription(VisitPrescription $prescription): array
    {

        $db = Database::instance();
        $statement = $db->prepare("select * from visit_prescription_items where prescription_id=?");
        $statement->execute([$prescription->id]);

        /** @var self[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($results)) {

            $output = [];

            foreach ($results as $result) {
                $result->drug = Drug::find($result->drug_id);

                $output[] = $result;
            }
            return $output;
        }
        return [];

    }
}
