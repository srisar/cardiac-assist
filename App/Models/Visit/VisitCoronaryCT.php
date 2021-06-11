<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;

class VisitCoronaryCT implements IModel
{
    private const TABLE = 'visit_coronary_ct';

    public ?int $id, $visit_id;
    public ?string $total_calcium_score, $origin, $dominance, $left_main,
        $lad, $lcx, $cardiac_valves, $pericardium,
        $extra_cardiac_findings, $impression;

    public ?Visit $visit;

    /**
     * @param $array
     * @return VisitCoronaryCT
     */
    public static function build($array): VisitCoronaryCT
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return VisitCoronaryCT|null
     */
    public static function find(int $id): ?VisitCoronaryCT
    {
        /** @var VisitCoronaryCT $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if (!empty($result)) {
            $result->visit = Visit::find($result->visit_id);
            return $result;
        }
        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitCoronaryCT[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'visit_id');
    }

    public function insert(): int
    {
        $data = [
            'visit_id' => $this->visit_id,
        ];
        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            'total_calcium_score' => $this->total_calcium_score,
            'origin' => $this->origin,
            'dominance' => $this->dominance,
            'left_main' => $this->left_main,
            'lad' => $this->lad,
            'lcx' => $this->lcx,
            'cardiac_valves' => $this->cardiac_valves,
            'pericardium' => $this->pericardium,
            'extra_cardiac_findings' => $this->extra_cardiac_findings,
            'impression' => $this->impression,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);

    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param Visit $visit
     * @return VisitCoronaryCT|null
     */
    public static function findByVisit(Visit $visit): ?VisitCoronaryCT
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_coronary_ct where visit_id=? limit 1');
        $statement->execute([$visit->id]);

        /** @var VisitCoronaryCT $result */
        $result = $statement->fetchObject(self::class);

        if (!empty($result)) {
            $result->visit = Visit::find($result->visit_id);
            return $result;
        }
        return null;

    }


}
