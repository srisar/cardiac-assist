<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class VisitSymptom implements AbstractModel
{

    private const TABLE = 'visit_symptoms';

    public ?int $id, $visit_id, $symptom_id;
    public ?Visit $visit;
    public ?Symptom $symptom;

    /**
     * @param array $fields
     * @return VisitSymptom
     */
    public static function build(array $fields)
    {
        $object = new self();
        foreach ( $fields as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return VisitSymptom|null
     */
    public static function find(int $id)
    {


        /** @var VisitSymptom $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if ( !empty($result) ) {

            $result->visit = $result->getVisit();
            $result->symptom = $result->getSymptom();

            return $result;
        }

        return $result;

    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitSymptom[]
     */
    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        /** @var VisitSymptom[] $result */
        $result = Database::findAll(self::TABLE, $limit, $offset, self::class);

        return $result;

    }

    public function insert()
    {
        $data = [
            'visit_id' => $this->visit_id,
            'symptom_id' => $this->symptom_id
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update()
    {
        $data = [
            'visit_id' => $this->visit_id,
            'symptom_id' => $this->symptom_id
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }


    /*
     * ---------------------------------------------------------------------------------------
     * | Other functions
     * ---------------------------------------------------------------------------------------
     */

    public function getVisit()
    {
        return Visit::find($this->visit_id);
    }

    public function getSymptom()
    {
        return Symptom::find($this->symptom_id);
    }

    public static function getVisitSymptomsByVisit(Visit $visit)
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from visit_symptoms where visit_id=?");
        $statement->execute([$visit->id]);

        /** @var VisitSymptom[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($result) ) return $result;
        return [];
    }


}