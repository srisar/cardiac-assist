<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Patient implements AbstractModel
{


    public ?int $id, $age, $income;
    public ?string $first_name, $last_name, $dob, $address, $ds_division, $nic,
        $phone, $gender, $job, $job_type, $status;

    public ?string $created_at, $updated_at;

    public const GENDER_LIST = [
        'MALE' => 'Male',
        'FEMALE' => 'Female',
    ];

    public const JOB_LIST = [
        'PERMANENT' => 'Permanent',
        'TEMPORARY' => 'Temporary',
        'DAILY_BASIS' => 'Daily Basis',
        'SELF_EMPLOYED' => 'Self Employed',
        'JOBLESS' => 'Jobless',
    ];

    public const JOB_TYPE_LIST = [
        'MANUAL' => 'Manual',
        'SEDENTARY' => 'Sedentary',
    ];


    public const DS_DIVISION_LIST = [
        'ERAVUR_PATTU' => 'Eravur Pattu',
        'KORALAI_PATTU_WEST' => 'Koralai Pattu West',
        'KORALAI_PATTU_NORTH' => 'Koralai Pattu North',
        'KORALAI_PATTU_SOUTH' => 'Koralai Pattu South',
        'KORALAI_PATTU_CENTRAL' => 'Koralai Pattu Central',
        'KORALAI_PATTU' => 'Koralai Pattu',
        'KATTANKUDY' => 'Kattankudy',
        'MANMUNAI_PATTU' => 'Manmunai Pattu',
        'MANMUNAI_SOUTH_ERUVIL_PATTU' => 'Manmunai South Eruvil Pattu',
        'MANMUNAI_WEST' => 'Manmunai West',
        'MANMUNAI_SOUTH_WEST' => 'Manmunai South West',
        'MANMUNAI_NORTH' => 'Manmunai North',
        'ERAVUR_TOWN' => 'Eravur Town',
        'PORAITHIVU_PATTU' => 'Poraithivu Pattu',
    ];

    public const STATUS_LIST = [
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive',
    ];

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';


    public static function build(array $fields): Patient
    {
        $object = new self();
        foreach ( $fields as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Patient|null
     */
    public static function find(int $id): ?Patient
    {
        return Database::find('patients', $id, self::class);

    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Patient[]|array
     */
    public static function findAll(int $limit = 1000, int $offset = 0): array
    {

        return Database::findAll('patients', $limit, $offset, self::class);
    }

    /**
     * Insert a new row into patients table
     */
    public function insert(): ?int
    {
        $db = Database::instance();
        $statement = $db->prepare(
            "insert into patients(first_name, last_name, dob, age, address, ds_division, nic, phone, gender, job, job_type, income, status) 
                values (:fn, :ln, :dob, :age, :address, :ds_div, :nic, :phone, :gender, :job, :job_t, :income, :status)"
        );

        $result = $statement->execute([
            ':fn' => $this->first_name,
            ':ln' => $this->last_name,
            ':dob' => $this->dob,
            ':age' => $this->age,
            ':address' => $this->address,
            ':ds_div' => $this->ds_division,
            ':nic' => $this->nic,
            ':phone' => $this->phone,
            ':gender' => $this->gender,
            ':job' => $this->job,
            ':job_t' => $this->job_type,
            ':income' => $this->income,
            ':status' => Patient::STATUS_ACTIVE,
        ]);

        if ( $result ) return $db->lastInsertId();
        return false;

    }

    public function update(): bool
    {
        $db = Database::instance();
        $statement = $db->prepare(
            "update patients set 
                    first_name= :fn,
                    last_name= :ln,
                    dob= :dob,
                    age= :age,
                    address= :address,
                    ds_division= :ds_div,
                    nic= :nic,
                    phone= :phone,
                    gender= :gender,
                    job= :job,
                    job_type= :job_t,
                    income= :income,
                    status= :status
                    where id= :id;"
        );

        return $statement->execute([
            ':fn' => $this->first_name,
            ':ln' => $this->last_name,
            ':dob' => $this->dob,
            ':age' => $this->age,
            ':address' => $this->address,
            ':ds_div' => $this->ds_division,
            ':nic' => $this->nic,
            ':phone' => $this->phone,
            ':gender' => $this->gender,
            ':job' => $this->job,
            ':job_t' => $this->job_type,
            ':income' => $this->income,
            ':status' => $this->status,
            ':id' => $this->id
        ]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    /*
     * ---------------------------------------------------------------------------------------
     * | Associated calls
     * ---------------------------------------------------------------------------------------
     */

    /**
     * @return Visit[]|array
     */
    public function getVisits(): array
    {
        return Visit::findByPatient($this);
    }


}