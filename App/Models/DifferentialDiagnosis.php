<?php


namespace App\Models;


use App\Core\Database\Database;

class DifferentialDiagnosis implements AbstractModel
{

    private const _TABLE = "differential_diagnosis";

    public ?int $id, $visit_id, $disease_id;


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
     * @return DifferentialDiagnosis|null
     */
    public static function find(int $id)
    {
        return Database::find(self::_TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return DifferentialDiagnosis[]
     */
    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        return Database::findAll(self::_TABLE, $limit, $offset, self::class);
    }

    public function insert()
    {
        $data = [
            'visit_id' => $this->visit_id,
            'disease_id' => $this->disease_id
        ];

        return Database::insert(self::_TABLE, $data);
    }

    public function update()
    {
        $data = [
            'visit_id' => $this->visit_id,
            'disease_id' => $this->disease_id
        ];

        return Database::update(self::_TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        return Database::delete(self::_TABLE, 'id', $this->id);
    }
}