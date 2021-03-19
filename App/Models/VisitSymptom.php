<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class VisitSymptom implements IModel
{

    private const TABLE = 'visit_symptoms';

    public ?int $id, $visit_id, $symptom_id, $duration;

    public ?Visit   $visit;
    public ?Symptom $symptom;

    /**
     * @param $array
     * @return VisitSymptom
     */
    public static function build($array): VisitSymptom
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return VisitSymptom|null
     */
    public static function find(int $id): ?VisitSymptom
    {
        $result = Database::find(self::TABLE, $id, self::class);
        if ( !empty($result) ) {
            $result->visit   = Visit::find($result->visit_id);
            $result->symptom = Symptom::find($result->symptom_id);

            return $result;
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitSymptom[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'visit_id');
    }

    public function insert(): int
    {
        $data = [
            'visit_id'   => $this->visit_id,
            'symptom_id' => $this->symptom_id,
            'duration'   => $this->duration,
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update()
    {

    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param Visit $visit
     * @return VisitSymptom[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db        = Database::instance();
        $statement = $db->prepare('select * from visit_symptoms where visit_id=?');
        $statement->execute([$visit->id]);


        /** @var VisitSymptom[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        $output = [];

        if ( !empty($results) ) {

            foreach ( $results as $result ) {
                $result->visit   = Visit::find($result->visit_id);
                $result->symptom = Symptom::find($result->symptom_id);
                $output[]        = $result;
            }

        }

        return $output;
    }

}
