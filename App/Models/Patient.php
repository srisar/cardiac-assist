<?php


namespace App\Models;


use App\Core\Database\Database;
use App\Models\Visit\Visit;
use PDO;
use stdClass;

class Patient implements IModel
{

    private const TABLE = 'patients';

    public ?int $id, $age, $income;
    public ?string $first_name, $last_name, $address, $ds_division, $nic, $phone, $job, $job_type, $dob, $gender, $status;

    public const STATUS_ACTIVE = 'ACTIVE';
//    public const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @param $array
     * @return Patient
     */
    public static function build( $array ): Patient
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Patient|null
     */
    public static function find( int $id ): ?Patient
    {
        return Database::find( self::TABLE, $id, self::class );
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Patient[]
     */
    public static function findAll( $limit = 1000, $offset = 0 ): array
    {
        return Database::findAll( self::TABLE, $limit, $offset, self::class, 'id', 'DESC' );
    }


    public function insert(): int
    {
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'dob' => $this->dob,
            'age' => $this->age,
            'address' => $this->address,
            'ds_division' => $this->ds_division,
            'nic' => $this->nic,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'job' => $this->job,
            'job_type' => $this->job_type,
            'income' => $this->income,
            'status' => self::STATUS_ACTIVE,
        ];

        return Database::insert( self::TABLE, $data );

    }


    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'dob' => $this->dob,
            'age' => $this->age,
            'address' => $this->address,
            'ds_division' => $this->ds_division,
            'nic' => $this->nic,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'job' => $this->job,
            'job_type' => $this->job_type,
            'income' => $this->income,
            'status' => $this->status,
        ];

        return Database::update( self::TABLE, $data, [ 'id' => $this->id ] );

    }

    /**
     *
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete( self::TABLE, 'id', $this->id );
    }


    /**
     * @param string $gender
     * @param array $age
     * @return Patient[]
     */
    public static function filter( string $gender = "ALL", array $age = [ 0, 100 ] ): array
    {

        $db = Database::instance();

        if ( strtoupper( $gender ) == 'ALL' ) {
            $statement = $db->prepare( 'select * from ' . self::TABLE .
                ' where age between :age_start and :age_end 
                order by first_name' );

            $statement->execute( [
                ':age_start' => $age[ 0 ],
                ':age_end' => $age[ 1 ],
            ] );


        } else {

            $statement = $db->prepare( 'select * from ' . self::TABLE .
                ' where gender = :gender and age between :age_start and :age_end 
                order by first_name' );

            $statement->execute( [
                ':gender' => $gender,
                ':age_start' => $age[ 0 ],
                ':age_end' => $age[ 1 ],
            ] );
        }

        $result = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $result ) ) return $result;
        return [];

    }


    public static function search( string $keyword ): array
    {
        $db = Database::instance();
        $statement = $db->prepare( "select * from patients 
                                            where first_name like :q or last_name like :q or phone like :q or address like :q" );

        $statement->execute( [ ":q" => "%" . $keyword . "%" ] );

        $results = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $results ) ) return $results;
        return [];

    }


    /**
     * @return Visit[]
     */
    public function getVisits(): array
    {
        return Visit::findByPatient( $this );
    }

    /**
     * @return Appointment[]
     */
    public function getAppointments(): array
    {
        return Appointment::findByPatient( $this );
    }

    /**
     * @return int[]
     */
    public static function getTotalCount(): array
    {
        $db = Database::instance();

        $output = [
            "total" => 0,
            "male" => 0,
            "female" => 0,
        ];

        $statement = $db->prepare( "select count(*) as total from patients" );
        $statement->execute();
        $result = $statement->fetchObject( stdClass::class );
        $output[ "total" ] = (int)$result->total;

        $statement = $db->prepare( "select count(*) as total from patients where gender='MALE'" );
        $statement->execute();
        $result = $statement->fetchObject( stdClass::class );
        $output[ "male" ] = (int)$result->total;

        $statement = $db->prepare( "select count(*) as total from patients where gender='FEMALE'" );
        $statement->execute();
        $result = $statement->fetchObject( stdClass::class );
        $output[ "female" ] = (int)$result->total;

        return $output;
    }

}
