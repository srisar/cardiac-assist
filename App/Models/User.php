<?php


namespace App\Models;


use App\Core\Database\Database;

class User implements IModel
{

    private const TABLE = 'users';

    public int $id;
    public string $username, $display_name, $password, $role, $password_string;

    const ROLES = [
        'ADMIN' => 'Administrator',
        'USER' => 'User',
        'MANAGER' => 'Manager',
    ];

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';
    const ROLE_MANAGER = 'MANAGER';


    /**
     * @param $array
     * @return User
     */
    public static function build($array): User
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * Find a user by id
     * @param int $id
     * @return User|null
     */
    public static function find(int $id): ?User
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from users where id=? limit 1");
        $statement->execute([$id]);

        $result = $statement->fetchObject(self::class);

        if (!empty($result)) return $result;
        return null;

    }


    /**
     * @param int $limit
     * @param int $offset
     * @return User[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'role');
    }

    /**
     * @return int
     */
    public function insert(): int
    {

        $hashedPassword = password_hash($this->password_string, PASSWORD_DEFAULT);

        $data = [
            'username' => $this->username,
            'display_name' => $this->display_name,
            'role' => $this->role,
            'password' => $hashedPassword
        ];

        return Database::insert(self::TABLE, $data);

    }

    /**
     * @return bool
     */
    public function update(): bool
    {

        $data = [
            'display_name' => $this->display_name,
            'role' => $this->role,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);

    }

    /**
     * @return bool
     */
    public function updateWithPassword(): bool
    {

        $hashedPassword = password_hash($this->password_string, PASSWORD_DEFAULT);

        $data = [
            'display_name' => $this->display_name,
            'role' => $this->role,
            'password' => $hashedPassword
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);

    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function findByUsername(string $username)
    {
        $db = Database::instance();
        $statement = $db->prepare("select * from users where username=? limit 1");
        $statement->execute([$username]);

        $result = $statement->fetchObject(self::class);

        if (!empty($result)) return $result;
        return null;
    }


}
