<?php


namespace App\Models;


use App\Core\Database\Database;

class Symptom implements AbstractModel
{

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
        // TODO: Implement update() method.
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

    public static function findByName(string $symptomName)
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from symptoms where symptom_name = ?');
        $statement->execute([$symptomName]);

        $result = $statement->fetchObject(self::class);

        if ( !empty($result) ) return $result;
        return null;
    }


}