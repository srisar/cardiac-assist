<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class EchoRemark implements IModel
{

    private const TABLE = "echo_remarks";

    public ?int $id;
    public ?string $value, $type;


    public static function build( $array ): self
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find( int $id ): ?EchoRemark
    {
        return Database::find( self::TABLE, $id, self::class );
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return EchoRemark[]
     */
    public static function findAll( $limit = 1000, $offset = 0 ): array
    {
        return Database::findAll( self::TABLE, $limit, $offset, self::class, "type" );
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $data = [
            "value" => $this->value,
            "type" => $this->type
        ];

        return Database::insert( self::TABLE, $data );

    }

    public function update(): bool
    {
        $data = [
            "value" => $this->value,
        ];

        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );

    }

    public function delete(): bool
    {
        return Database::delete( self::TABLE, "id", $this->id );
    }

    /**
     * @param $type
     * @return EchoRemark[]
     */
    public static function findByType( $type ): array
    {

        $db = Database::instance();
        $statement = $db->prepare( "select * from echo_remarks where type=? order by value" );
        $statement->execute( [ $type ] );

        /** @var EchoRemark[] $result */
        $result = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $result ) ) return $result;
        return [];

    }

}

