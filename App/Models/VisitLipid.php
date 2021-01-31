<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

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
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find(int $id): ?VisitLipid
    {
        /** @var VisitLipid $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if ( !empty($result) ) {
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

    public function insert()
    {
        $data = [
            'visit_id' => $this->visit_id,
            'tc' => $this->tc,
            'ldl' => $this->ldl,
            'hdl' => $this->hdl,
            'tg' => $this->tg,
            'nhc' => $this->nhc,
        ];

        return Database::insert(self::TABLE, $data);
    }

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

    public function delete(): bool
    {
        /*
         * NOT USEFUL
         * */
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param Visit $visit
     * @return VisitLipid[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_lipids where visit_id=?');
        $statement->execute([$visit->id]);

        /** @var VisitLipid[] $results */
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
