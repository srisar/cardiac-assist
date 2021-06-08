<?php


namespace App\Models;


use App\Core\Database\Database;
use Exception;
use PDO;

class VisitFurtherInvestigation implements IModel
{

    private const TABLE = "visit_further_investigations";


    public ?int $id, $visit_id, $investigation_id;
    public ?string $remarks;

    public ?Visit $visit;
    public ?Investigation $investigation;

    /**
     * @param $array
     * @return self
     */
    public static function build($array): self
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }


    public static function find(int $id): ?VisitFurtherInvestigation
    {

        /** @var self $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if (!empty($result)) {
            $result->visit = Visit::find($result->visit_id);
            $result->investigation = Investigation::find($result->investigation_id);

            return $result;

        }

        return null;

    }

    /**
     * @throws Exception
     */
    public static function findAll($limit = 1000, $offset = 0)
    {
        throw new Exception("Not implemented");
    }

    public function insert(): int
    {
        $data = [
            'visit_id' => $this->visit_id,
            'investigation_id' => $this->investigation_id,
            'remarks' => $this->remarks,
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            'remarks' => $this->remarks,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param Visit $visit
     * @return self[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_further_investigations where visit_id=?');
        $statement->execute([$visit->id]);


        /** @var self[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        $output = [];

        if (!empty($results)) {

            foreach ($results as $result) {
                $result->visit = Visit::find($result->visit_id);
                $result->investigation = Investigation::find($result->investigation_id);
                $output[] = $result;
            }

        }

        return $output;
    }

}
