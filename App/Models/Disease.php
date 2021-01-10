<?php


namespace App\Models;


use App\Core\Database\Database;
use Symfony\Component\VarDumper\Cloner\Data;

class Disease implements IModel
{

    private const TABLE = 'diseases';

    public ?int $id;
    public ?string $disease, $disease_code, $description;

    public ?string $created_at, $updated_at;

    /**
     * @param $array
     * @return Disease
     */
    public static function build($array): Disease
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Disease|null
     */
    public static function find(int $id): ?Disease
    {
        return Database::find(self::TABLE, $id, self::class);
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return Disease[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'disease');
    }


    /**
     * @return bool|int|null
     */
    public function insert()
    {
        $data = [
            'disease' => $this->disease,
            'disease_code' => $this->disease_code,
            'description' => $this->description
        ];

        return Database::insert(self::TABLE, $data);

    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'disease' => $this->disease,
            'disease_code' => $this->disease_code,
            'description' => $this->description
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);

    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    /**
     * @param $disease
     * @return Disease|null
     */
    public static function findByName($disease): ?Disease
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from diseases where disease=? limit 1");
        $statement->execute([$disease]);

        $result = $statement->fetchObject(self::class);

        if ( !empty($result) ) return $result;
        return null;
    }

}
