<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;
use App\Models\Problem;
use PDO;

class VisitProblem implements IModel
{

    private const TABLE = "visit_problems";

    public ?int $id, $visit_id, $problem_id;
    public ?string $remarks;

    public ?Visit $visit;
    public ?Problem $problem;

    public static function build( $array ): self
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find( int $id )
    {
        return Database::find( self::TABLE, $id, self::class );
    }

    public static function findAll( $limit = 1000, $offset = 0 )
    {
        // TODO: Implement findAll() method.
    }

    public function insert(): int
    {
        $data = [
            "visit_id" => $this->visit_id,
            "problem_id" => $this->problem_id,
            "remarks" => $this->remarks,
        ];

        return Database::insert( self::TABLE, $data );
    }

    public function update(): bool
    {
        $data = [
            "remarks" => $this->remarks,
        ];

        return Database::update( self::TABLE, $data, [ 'id' => $this->id ] );
    }

    public function delete(): bool
    {
        return Database::delete( self::TABLE, "id", $this->id );
    }

    /**
     * @param Visit $visit
     * @return self[]
     */
    public static function findByVisit( Visit $visit ): array
    {
        $db = Database::instance();
        $statement = $db->prepare( "select * from visit_problems where visit_id=?" );
        $statement->execute( [ $visit->id ] );

        /** @var self[] $results */
        $results = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $results ) ) {

            $output = [];

            foreach ( $results as $result ) {
                $result->problem = Problem::find( $result->problem_id );
                $output[] = $result;
            }
            return $output;
        }
        return [];

    }

}
