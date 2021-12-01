<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Investigation implements IModel
{

    private const TABLE = 'investigations';

    public ?int $id = -1;
    public ?string $investigation_name, $description;

    /**
     * @param $array
     * @return Investigation
     */
    public static function build($array): Investigation
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return Investigation|null
     */
    public static function find(int $id): ?Investigation
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Investigation[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'investigation_name');
    }

    public function insert(): int
    {
        $data = [
            'investigation_name' => $this->investigation_name,
            'description' => $this->description
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            'investigation_name' => $this->investigation_name,
            'description' => $this->description
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param $investigation_name
     * @return Investigation|null
     */
    public static function findByName($investigation_name): ?Investigation
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from investigations where investigation_name=? limit 1");
        $statement->execute([$investigation_name]);

        $result = $statement->fetchObject(self::class);

        if (!empty($result)) return $result;
        return null;
    }

    public static function search( string $keyword ): array
    {

        $db = Database::instance();
        $statement = $db->prepare( "select * from investigations where investigations.investigation_name like :q" );
        $statement->execute( [
            ":q" => $keyword . "%",
        ] );

        $result = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $result ) ) return $result;
        return [];

    }


}
