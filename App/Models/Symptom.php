<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Symptom implements IModel
{

    private const TABLE = 'symptoms';

    public ?int $id;
    public ?string $symptom_name, $description;


    public static function build( $array ): self
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return Symptom|null
     */
    public static function find( int $id ): ?Symptom
    {
        return Database::find( self::TABLE, $id, self::class );
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Symptom[]
     */
    public static function findAll( $limit = 1000, $offset = 0 ): array
    {
        return Database::findAll( self::TABLE, $limit, $offset, self::class, 'symptom_name' );
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $data = [
            'symptom_name' => $this->symptom_name,
            'description' => $this->description,
        ];

        return Database::insert( self::TABLE, $data );
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'symptom_name' => $this->symptom_name,
            'description' => $this->description,
        ];

        return Database::update( self::TABLE, $data, [ 'id' => $this->id ] );

    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete( self::TABLE, 'id', $this->id );
    }


    /**
     * @param $symptom_name
     * @return Symptom|null
     */
    public static function findByName( $symptom_name ): ?Symptom
    {
        $db = Database::instance();
        $statement = $db->prepare( "select * from symptoms where symptom_name=? limit 1" );
        $statement->execute( [ $symptom_name ] );

        $result = $statement->fetchObject( self::class );

        if ( !empty( $result ) ) return $result;
        return null;
    }

    public static function search( string $keyword ): array
    {

        $db = Database::instance();
        $statement = $db->prepare( "select * from symptoms where symptom_name like :q" );
        $statement->execute( [
            ":q" => "%" . $keyword . "%",
        ] );

        $result = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $result ) ) return $result;
        return [];

    }

}
