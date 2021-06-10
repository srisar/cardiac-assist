<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class EchoRemarks implements IModel
{

    private const TABLE = "echo_remarks";

    public ?int $id;
    public ?string $value, $type;

    public const TYPE_LEFT_VENTRICLE = "LEFT_VENTRICLE";
    public const TYPE_LEFT_ATRIUM = "LEFT_ATRIUM";
    public const TYPE_MITRAL_VALVE = "MITRAL_VALVE";
    public const TYPE_AORTIC_VALVE = "AORTIC_VALVE";
    public const TYPE_AORTA = "AORTA";
    public const TYPE_RIGHT_VENTRICLE = "RIGHT_VENTRICLE";
    public const TYPE_RIGHT_ATRIUM = "RIGHT_ATRIUM";
    public const TYPE_PULMONIC_VALVE = "PULMONIC_VALVE";
    public const TYPE_TRICUSPID = "TRICUSPID";
    public const TYPE_PERICARDIUM = "PERICARDIUM";
    public const TYPE_CONCLUSION = "CONCLUSION";


    public static function build($array): EchoRemarks
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find(int $id): ?EchoRemarks
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return EchoRemarks[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, "type");
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $data = [
            "value" => $this->value,
            "type" => $this->type
        ];

        return Database::insert(self::TABLE, $data);

    }

    public function update(): bool
    {
        $data = [
            "value" => $this->value,
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);

    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }

    /**
     * @param $type
     * @return EchoRemarks[]
     */
    public static function findByType($type): array
    {

        $db = Database::instance();
        $statement = $db->prepare(sprintf("select * from %s where type=?", self::TABLE));
        $statement->execute([$type]);

        /** @var EchoRemarks[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($result)) return $result;
        return [];

    }

}

