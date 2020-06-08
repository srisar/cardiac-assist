<?php


namespace App\Models;


use App\Core\Database\Database;

class VisitSymptom implements AbstractModel
{

    private const TABLE = 'visit_symptoms';

    public ?int $id, $visit_id, $symptom_id;

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
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitSymptom[]
     */
    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class);
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
}