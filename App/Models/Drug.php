<?php


namespace App\Models;


use App\Core\Database\Database;
use Exception;
use mysql_xdevapi\Statement;
use PDO;

class Drug implements IModel
{

    private const TABLE = "drugs";

    public ?int $id;
    public ?string $drug_name, $remarks;

    public static function build($array): self
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Drug|null
     */
    public static function find(int $id): ?Drug
    {
        return Database::find(self::TABLE, $id, self::class);
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return Drug[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, "drug_name");
    }

    public function insert(): int
    {
        $data = [
            "drug_name" => $this->drug_name,
            "remarks" => $this->remarks,
        ];
        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            "drug_name" => $this->drug_name,
            "remarks" => $this->remarks,
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    /**
     * @throws Exception
     */
    public function delete()
    {
        throw new Exception("Not implemented");
    }


    /**
     * @param $name
     * @return Drug|null
     */
    public static function findByName($name): ?Drug
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from drugs where drug_name=? limit 1");
        $statement->execute([$name]);

        $result = $statement->fetchObject(self::class);

        if (!empty($result)) return $result;
        return null;
    }

    public static function search(string $keyword): array
    {

        $db = Database::instance();
        $statement = $db->prepare("select * from drugs where drug_name like :q or remarks like :q");
        $statement->execute([
            ":q" => "%" . $keyword . "%"
        ]);

        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($result)) return $result;
        return [];

    }

}
