<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

class DifferentialDiagnosis implements IModel
{

    private const TABLE = 'differential_diagnoses';

    public ?int $id = 0, $visit_id = 0, $disease_id = 0;
    public ?string $remarks;

    public ?Visit $visit;
    public ?Disease $disease;

    /**
     * @param $array
     * @return DifferentialDiagnosis
     */
    public static function build($array): DifferentialDiagnosis
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return DifferentialDiagnosis|null
     */
    public static function find(int $id): ?DifferentialDiagnosis
    {

        $result = Database::find(self::TABLE, $id, self::class);

        if ( !empty($result) ) {
            $result->visit = Visit::find($result->visit_id);
            $result->disease = Disease::find($result->symptom_id);

            return $result;
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return DifferentialDiagnosis[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'visit_id');
    }


    public function insert()
    {
        $data = [
            'visit_id' => $this->visit_id,
            'disease_id' => $this->disease_id,
            'remarks' => $this->remarks
        ];

        return Database::insert(self::TABLE, $data);
    }


    public function update(): bool
    {
        $data = [
            'remarks' => $this->remarks
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }


    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }


    /**
     * @param Visit $visit
     * @return DifferentialDiagnosis[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from differential_diagnoses where visit_id=?');
        $statement->execute([$visit->id]);


        /** @var DifferentialDiagnosis[] $results */
        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        $output = [];

        if ( !empty($results) ) {

            foreach ( $results as $result ) {
                $result->visit = Visit::find($result->visit_id);
                $result->disease = Disease::find($result->disease_id);
                $output[] = $result;
            }

        }

        return $output;
    }


}
