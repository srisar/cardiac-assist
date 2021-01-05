<?php


namespace App\Models;


use App\Core\Database\Database;

class Subject implements IModel
{

    private const TABLE = 'subjects';

    public ?int $id;
    public ?string $subject_name;

    public static function build($array): Subject
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Subject|null
     */
    public static function find(int $id): ?Subject
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Subject[]|null
     */
    public static function findAll($limit = 1000, $offset = 0): ?array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'subject_name');
    }

    /**
     * @return bool|int
     */
    public function insert()
    {
        $data = [
            'subject_name' => $this->subject_name
        ];

        return Database::insert(self::TABLE, $data);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'subject_name' => $this->subject_name
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $subject_name
     * @return Subject|null
     */
    public static function getSubjectByName($subject_name): ?Subject
    {
        $db = Database::instance();
        $statement = $db->prepare('SELECT * FROM ' . self::TABLE . ' WHERE subject_name=?');
        $statement->execute([$subject_name]);

        $data = $statement->fetchObject(self::class);
        if ( !empty($data) ) return $data;
        return null;
    }

}