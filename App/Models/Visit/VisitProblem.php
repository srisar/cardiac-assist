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

    public ?Visit $visit;
    public ?Problem $problem;

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

    public static function findAll($limit = 1000, $offset = 0)
    {
        // TODO: Implement findAll() method.
    }

    public function insert(): int
    {
        $data = [
            "visit_id" => $this->visit_id,
            "problem_id" => $this->problem_id
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }

    /**
     * @param Visit $visit
     * @return self[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from visit_problems where visit_id=?");
        $statement->execute([$visit->id]);

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($results)) return $results;
        return [];

    }

}
