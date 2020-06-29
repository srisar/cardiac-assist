<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Symptom implements AbstractModel
{

    private const TABLE = "symptoms";

    public ?int $id;
    public ?string $symptom_name, $description, $created_at, $updated_at;


    /**
     * @param array $fields
     * @return Symptom
     */
    public static function build(array $fields)
    {
        $object = new self();
        foreach ( $fields as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Symptom|null
     */
    public static function find(int $id)
    {
        return Database::find('symptoms', $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Symptom[]
     */
    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        return Database::findAll('symptoms', $limit, $offset, self::class);
    }

    /**
     * @return bool|string
     */
    public function insert()
    {
        $data = [
            'symptom_name' => $this->symptom_name,
            'description' => $this->description
        ];

        return Database::insert('symptoms', $data);
    }

    public function update()
    {
        $data = [
            'symptom_name' => $this->symptom_name,
            'description' => $this->description
        ];

        return Database::update('symptoms', $data, ['id' => $this->id]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /*
     * ---------------------------------------------------------------------------------------
     * | Other functions
     * ---------------------------------------------------------------------------------------
     */

    /**
     * @param string $symptomName
     * @return Symptom|null
     */
    public static function findByName(string $symptomName)
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from symptoms where symptom_name = ?');
        $statement->execute([$symptomName]);

        $result = $statement->fetchObject(self::class);

        if ( !empty($result) ) return $result;
        return null;
    }


    /**
     * @param string $symptomName
     * @return Symptom[]|bool
     */
    public static function searchByName(?string $symptomName)
    {
        $db = Database::instance();

        $statement = $db->prepare(
            "select * from " . self::TABLE . " where symptom_name like :query;"
        );

        $statement->bindValue(":query", "%" . $symptomName . "%");

        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($results) ) return $results;
        return [];
    }


    public static function findByVisit(Visit $visit)
    {

    }

}