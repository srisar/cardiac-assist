<?php


namespace App\Models;


use App\Core\Database\Database;
use Exception;

class VisitPrescriptionItem implements IModel
{

    private const TABLE = "visit_prescription_items";

    public ?int $id, $visit_id, $prescription_id, $drug_id;
    public ?string $date, $frequency, $duration, $remarks;

    public ?Visit $visit;
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

            $result->visit = Visit::find($result->visit_id);
            $result->prescription = VisitPrescription::find($result->prescription_id);
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
            "visit_id" => $this->visit_id,
            "prescription_id" => $this->prescription_id,
            "drug_id" => $this->drug_id,
            "date" => $this->date,
            "frequency" => $this->frequency,
            "duration" => $this->duration,
            "remarks" => $this->remarks,
        ];

        return Database::insert(self::TABLE, $data);

    }

    public function update(): bool
    {
        $data = [
            "date" => $this->date,
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
}
