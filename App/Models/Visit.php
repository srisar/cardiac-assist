<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Visit implements AbstractModel
{

    public ?int $id, $patient_id;
    public ?string $remarks, $visit_date, $added_at, $updated_at;

    /**
     * @param array $fields
     * @return Visit
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
     * @return Visit|null
     */
    public static function find(int $id)
    {
        return Database::find('visits', $id, self::class);

    }

    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        return Database::findAll('visits', $limit, $offset, self::class);
    }

    public function insert()
    {

        $data = [
            'patient_id' => $this->patient_id,
            'remarks' => $this->remarks,
            'visit_date' => $this->visit_date,
        ];

        return Database::insert('visits', $data);

    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /*
     * ---------------------------------------------------------------------------------------
     * | Other functions
     * ---------------------------------------------------------------------------------------
     */

    /**
     * @param Patient $patient
     * @return Visit[]|array
     */
    public static function findByPatient(Patient $patient)
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from visits where patient_id=?");
        $statement->execute([$patient->id]);

        /** @var Visit[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($result) ) return $result;
        return [];

    }
}