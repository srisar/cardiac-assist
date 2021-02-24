<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class VisitInvestigation implements IModel
{
    private const TABLE = 'visit_investigations';

    public ?int $id = -1, $visit_id = -1, $investigation_id = -1;
    public ?string $remarks = "";

    public ?Visit $visit;
    public ?Investigation $investigation;


    /**
     * @param $array
     * @return VisitInvestigation
     */
    public static function build($array): VisitInvestigation
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return VisitInvestigation|null
     */
    public static function find(int $id): ?VisitInvestigation
    {
        /** @var VisitInvestigation $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if ( !empty($result) ) {
            $result->visit = Visit::find($result->visit_id);
            $result->investigation = Investigation::find($result->investigation_id);

            return $result;
        }

        return null;
    }

    public static function findAll($limit = 1000, $offset = 0)
    {

    }

    public function insert()
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

    public function delete()
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param Visit $visit
     * @return VisitInvestigation[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_investigations where visit_id=?');
        $statement->execute([$visit->id]);


        /** @var VisitInvestigation[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        $output = [];

        if ( !empty($results) ) {

            foreach ( $results as $result ) {
                $result->visit = Visit::find($result->visit_id);
                $result->investigation = Investigation::find($result->investigation_id);
                $output[] = $result;
            }

        }

        return $output;
    }
}
