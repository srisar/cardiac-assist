<?php


namespace App\Models;


use App\Core\Database\Database;

class Supplier implements IModel
{

    private const TABLE = 'suppliers';

    public ?int $id;
    public ?string $supplier_name, $address, $telephone, $email, $website;


    public static function build($array): Supplier
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return Supplier|null
     */
    public static function find(int $id): ?Supplier
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Supplier[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'supplier_name');
    }

    /**
     * @return bool|int
     */
    public function insert()
    {
        $data = [
            'supplier_name' => $this->supplier_name,
            'address' => $this->address,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'website' => $this->website,
        ];

        return Database::insert(self::TABLE, $data);

    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'supplier_name' => $this->supplier_name,
            'address' => $this->address,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'website' => $this->website,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    /**
     * @param $supplier_name
     * @return Supplier|null
     */
    public static function getSupplierByName($supplier_name): ?Supplier
    {
        $db = Database::instance();
        $statement = $db->prepare('SELECT * FROM ' . self::TABLE . ' WHERE supplier_name=?');
        $statement->execute([$supplier_name]);

        $data = $statement->fetchObject(self::class);
        if ( !empty($data) ) return $data;
        return null;
    }

}