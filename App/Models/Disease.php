<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Disease implements AbstractModel
{

    private const _TABLE = "diseases";

    public ?int $id;
    public ?string $disease, $disease_code, $description, $created_at, $updated_at;


    /**
     * @param array $fields
     * @return Disease
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
     * @return Disease|null
     */
    public static function find(int $id)
    {
        return Database::find(self::_TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Disease[]
     */
    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        return Database::findAll(self::_TABLE, $limit, $offset, self::class);
    }


    public function insert()
    {
        $data = [
            "disease" => $this->disease,
            "disease_code" => $this->disease_code,
            "description" => $this->description
        ];

        return Database::insert(self::_TABLE, $data);

    }

    public function update()
    {
        $data = [
            "disease" => $this->disease,
            "disease_code" => $this->disease_code,
            "description" => $this->description
        ];

        return Database::update(self::_TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        Database::delete(self::_TABLE, 'id', $this->id);
    }

    /*
    * ---------------------------------------------------------------------------------------
    * | Other functions
    * ---------------------------------------------------------------------------------------
    */

    /**
     * @param string $diseaseName
     * @return Disease|null
     */
    public static function findByName(string $diseaseName)
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from diseases where disease = ?');
        $statement->execute([$diseaseName]);

        $result = $statement->fetchObject(self::class);

        if ( !empty($result) ) return $result;
        return null;
    }

    /**
     * @param string $diseaseName
     * @return Disease[]|bool
     */
    public static function searchByName(string $diseaseName)
    {
        $db = Database::instance();

        $statement = $db->prepare(
            "select * from " . self::_TABLE . " where disease like :query;"
        );

        $statement->bindValue(":query", "%" . $diseaseName . "%");

        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($results) ) return $results;
        return [];
    }


}