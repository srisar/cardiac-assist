<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Visit implements IModel
{

    private const TABLE = 'visits';

    public ?int $id = -1, $patient_id = -1;
    public ?string $visit_date, $remarks;

    public ?string $added_at, $updated_at;

    public ?Patient $patient;

    public static function build($array): Visit
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return Visit|null
     */
    public static function find(int $id): ?Visit
    {
        /** @var Visit $visit */
        $visit = Database::find(self::TABLE, $id, self::class);

        if ( !empty($visit) ) {
            $visit->patient = Patient::find($visit->patient_id);
        }

        return $visit;

    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'patient_id');
    }


    public function insert()
    {
        $data = [
            'patient_id' => $this->patient_id,
            'visit_date' => $this->visit_date,
            'remarks' => $this->remarks,
        ];

        return Database::insert(self::TABLE, $data);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'visit_date' => $this->visit_date,
            'remarks' => $this->remarks,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    /**
     * @param Patient $patient
     * @return Visit[]
     */
    public static function findByPatient(Patient $patient): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visits where patient_id=?');
        $statement->execute([$patient->id]);

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($results) ) return $results;
        return [];

    }
}
