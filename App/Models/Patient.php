<?php


namespace App\Models;


use App\Core\Database\Database;

class Patient implements AbstractModel
{


    public ?int $id, $age, $income;
    public ?string $first_name, $last_name, $dob, $address, $ds_division, $nic,
        $phone, $gender, $job, $job_type, $status;

    public ?string $created_at, $updated_at;

    public const SEX_LIST = [
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


    public static function build(array $fields)
    {
        $object = new Patient();
        foreach ( $fields as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Patient|null
     */
    public static function find(int $id)
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from patients where id=?");
        $statement->execute([$id]);

        /** @var Patient $result */
        $result = $statement->fetchObject(Patient::class);

        if ( !empty($result) ) return $result;
        return null;

    }

    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        // TODO: Implement findAll() method.
    }

    /**
     * Insert a new row into patients table
     * @return bool
     */
    public function insert()
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
        return $result;


    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}