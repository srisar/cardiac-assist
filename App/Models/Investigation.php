<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

class Investigation implements IModel
{

    private const TABLE = 'investigations';

    public ?int $id = -1, $visit_id = -1;
    public ?string $investigation_name, $description;
    public ?Visit $visit;

    /**
     * @param $array
     * @return Investigation
     */
    public static function build($array): Investigation
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return Investigation
     */
    public static function find(int $id)
    {
        /** @var Investigation $investigation */
        $investigation = Database::find(self::TABLE, $id, self::class);

        if ( !empty($investigation) ) {
            $investigation->visit = Visit::find($investigation->visit_id);
        }

        return $investigation;

    }

    public static function findAll($limit = 1000, $offset = 0)
    {
        // TODO: Implement findAll() method.
    }

    public function insert()
    {
        $data = [
            'visit_id' => $this->visit_id,
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
     * @param Visit $visit
     * @return Investigation[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from investigations where visit_id=?');
        $statement->execute([$visit->id]);


        /** @var Investigation[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        $output = [];

        if ( !empty($results) ) {

            foreach ( $results as $result ) {
                $result->visit = Visit::find($result->visit_id);
                $output[] = $result;
            }

        }

        return $output;
    }

}
