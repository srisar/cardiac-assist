<?php


namespace App\Models;

use App\Core\Database\Database;
use PDO;

class VisitECG implements IModel
{

    private const TABLE = 'visit_ecg';

    public ?int $id, $visit_id;
    public ?string   $description;

    public ?Visit $visit;


    /**
     * Build a new object from passed array
     * @param $array
     * @return VisitECG
     */
    public static function build($array): VisitECG
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    public static function find(int $id): ?VisitECG
    {
        /** @var VisitECG $visitEcg */
        $visitEcg = Database::find(self::TABLE, $id, self::class);

        if ( !empty($visitEcg) ) {
            $visitEcg->visit = Visit::find($visitEcg->visit_id);
        }

        return $visitEcg;

    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitECG[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        /** @var VisitECG[] $result */
        $result = Database::findAll(self::TABLE, $limit, $offset, self::class, ['visit_id']);

        if ( !empty($result) ) {
            $output = [];
            foreach ( $result as $visitECG ) {
                $visitECG->visit = Visit::find($visitECG->visit_id);
                $output[]        = $visitECG;
            }

            return $output;
        }

        return [];

    }

    public function insert(): int
    {
        $data = [
            'visit_id'    => $this->visit_id,
        ];
        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
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
     * @return VisitECG
     */
    public static function findByVisit(Visit $visit): ?VisitECG
    {
        $db        = Database::instance();
        $statement = $db->prepare('select * from visit_ecg where visit_id=? limit 1');
        $statement->execute([$visit->id]);

        /** @var VisitECG $results */
        $result = $statement->fetchObject(self::class);

        if ( !empty($result) ) {
            $result->visit = Visit::find($result->visit_id);
            return $result;
        }
        return null;
    }


}
