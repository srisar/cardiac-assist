<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;

class VisitLipid implements IModel
{

    private const TABLE = 'visit_lipids';

    public ?int $id, $visit_id;
    public ?float $tc, $ldl, $hdl, $tg, $nhc;

    public ?Visit $visit;


    /**
     * @param $array
     * @return VisitLipid
     */
    public static function build($array): VisitLipid
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find(int $id): ?VisitLipid
    {
        /** @var VisitLipid $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if (!empty($result)) {
            $result->visit = Visit::find($result->visit_id);
        }

        return $result;

    }

    public static function findAll($limit = 1000, $offset = 0)
    {
        /*
         * NOT USEFUL
         * */
    }

    /**
     * Insert into database
     * @return int
     */
    public function insert(): int
    {
        $data = [
            'visit_id' => $this->visit_id,
        ];

        return Database::insert(self::TABLE, $data);
    }

    /**
     * update existing values in database
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'tc' => $this->tc,
            'ldl' => $this->ldl,
            'hdl' => $this->hdl,
            'tg' => $this->tg,
            'nhc' => $this->nhc,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);

    }

    /**
     * delete from database
     * @return bool
     */
    public function delete(): bool
    {
        /*
         * NOT USEFUL
         * */
        return Database::delete(self::TABLE, 'id', $this->id);
    }


    /**
     * @param Visit $visit
     * @return VisitLipid|null
     */
    public static function findByVisit(Visit $visit): ?VisitLipid
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_lipids where visit_id=? limit 1');
        $statement->execute([$visit->id]);

        /** @var VisitLipid $result */
        $result = $statement->fetchObject(self::class);


        if (!empty($result)) {
            $result->visit = Visit::find($result->visit_id);
            return $result;
        }

        return null;
    }
}
