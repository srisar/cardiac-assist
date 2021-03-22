<?php


namespace App\Models;


use App\Core\Database\Database;

class EchoLeftAtriumValue implements IModel
{

    private const TABLE = 'echo_left_atrium_values';

    public ?int    $id;
    public ?string $value;


    public static function build($array): EchoLeftAtriumValue
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return EchoLeftAtriumValue|null
     */
    public static function find(int $id): ?EchoLeftAtriumValue
    {
        return Database::find(self::TABLE, $id, self::class);
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return EchoLeftAtriumValue[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'value');
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $data = [
            'value' => $this->value
        ];
        return Database::insert(self::TABLE, $data);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'value' => $this->value
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

}