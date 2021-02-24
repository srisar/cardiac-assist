<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Appointment implements IModel
{

    private const TABLE = 'appointments';

    public ?int $id, $patient_id;
    public ?string $date, $remarks, $status;

    public ?Patient $patient;

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_COMPLETED = 'COMPLETED';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_MISSED = 'MISSED';


    /**
     * @param $array
     * @return Appointment
     */
    public static function build($array): Appointment
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Appointment
     */
    public static function find(int $id): Appointment
    {
        /** @var Appointment $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if ( !empty($result) ) {
            $result->patient = Patient::find($result->patient_id);
        }

        return $result;

    }

    /**
     * @param Patient $patient
     * @return Appointment[]
     */
    public static function findByPatient(Patient $patient): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from appointments where patient_id=?');
        $statement->execute([$patient->id]);

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($results) ) return $results;
        return [];

    }

    public static function findAll($limit = 1000, $offset = 0)
    {
        // TODO: Implement findAll() method.
    }

    public function insert()
    {
        $data = [
            'patient_id' => $this->patient_id,
            'date' => $this->date,
            'remarks' => $this->remarks,
            'status' => self::STATUS_PENDING
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            'date' => $this->date,
            'remarks' => $this->remarks,
            'status' => $this->status
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }
}
