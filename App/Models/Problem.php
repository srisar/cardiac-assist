<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Problem implements IModel
{

    private const TABLE = "problems";

    public ?int $id;
    public ?string $problem;

    public static function build($array): self
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }


    public static function find(int $id)
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return self[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, "problem");
    }

    public function insert(): int
    {
        $data = [
            "problem" => $this->problem
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            "problem" => $this->problem
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }

    public static function search( string $keyword ): array
    {

        $db = Database::instance();
        $statement = $db->prepare( "select * from problems where problem like :q" );
        $statement->execute( [
            ":q" => "%". $keyword . "%",
        ] );

        $result = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $result ) ) return $result;
        return [];

    }

}
