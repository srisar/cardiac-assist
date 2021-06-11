<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\Disease;
use App\Models\IModel;
use PDO;

class VisitDiagnosis implements IModel
{

    private const TABLE = 'visit_diagnoses';

    public ?int $id = 0, $visit_id = 0, $disease_id = 0;
    public ?string $remarks;

    public ?Visit $visit;
    public ?Disease $disease;

    /**
     * @param $array
     * @return VisitDiagnosis
     */
    public static function build($array): VisitDiagnosis
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return VisitDiagnosis|null
     */
    public static function find(int $id): ?VisitDiagnosis
    {

        /** @var VisitDiagnosis $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if (!empty($result)) {
            $result->visit = Visit::find($result->visit_id);
            $result->disease = Disease::find($result->disease_id);

            return $result;
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitDiagnosis[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'visit_id');
    }


    public function insert(): int
    {
        $data = [
            'visit_id' => $this->visit_id,
            'disease_id' => $this->disease_id,
            'remarks' => $this->remarks
        ];

        return Database::insert(self::TABLE, $data);
    }


    public function update(): bool
    {
        $data = [
            'remarks' => $this->remarks
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }


    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }


    /**
     * @param Visit $visit
     * @return VisitDiagnosis[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_diagnoses where visit_id=?');
        $statement->execute([$visit->id]);


        /** @var VisitDiagnosis[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        $output = [];

        if (!empty($results)) {

            foreach ($results as $result) {
                $result->visit = Visit::find($result->visit_id);
                $result->disease = Disease::find($result->disease_id);
                $output[] = $result;
            }

        }

        return $output;
    }


}
