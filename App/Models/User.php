<?php


namespace App\Models;


use App\Core\Database\Database;
use mysql_xdevapi\Statement;
use PDO;

class User implements AbstractModel
{

    public ?int $id;
    public ?string $username, $password, $display_name, $role, $created_at, $updated_at;


    public const ROLE_LIST = [
        'ADMIN' => 'Administrator',
        'MANAGER' => 'Manager',
        'USER' => 'User'
    ];

    public const ROLE_ADMIN = 'ADMIN';
    public const ROLE_MANAGER = 'MANAGER';
    public const ROLE_USER = 'USER';
    public const ROLE_NONE = 'NONE';

    public static function build($fields)
    {
        $object = new self();
        foreach ( $fields as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return User|null
     */
    public static function find(int $id)
    {
        $db = Database::instance();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);

        /** @var User $result */
        $result = $stmt->fetchObject(User::class);

        if ( !empty($result) ) return $result;
        return null;
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return User[]|array
     */
    public static function findAll(int $limit = 1000, int $offset = 0)
    {
        $db = Database::instance();
        $statement = $db->prepare("SELECT * FROM users LIMIT :limit_value OFFSET :offset_value");
        $statement->bindValue(':limit_value', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset_value', $offset, PDO::PARAM_INT);

        $statement->execute();

        /** @var User[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, User::class);

        if ( !empty($result) ) {
            return $result;
        }
        return [];
    }

    public function insert()
    {
        $db = Database::instance();
        $statement = $db->prepare("INSERT INTO users(username, password, display_name, role) values (?, ?, ?, ?)");

        if ( $statement->execute([$this->username, $this->password, $this->display_name, $this->role]) ) {
            return true;
        }

        return false;
    }


    public function update()
    {
        $db = Database::instance();
        $statement = $db->prepare("UPDATE users SET username=?, password=?, display_name=?, role=? WHERE id=?;");

        return $statement->execute([
            $this->username,
            $this->password,
            $this->display_name,
            $this->role,
            $this->id
        ]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * Returns a user by username, if exists
     * @param string $username
     * @return User|null
     */
    public static function findByUsername(string $username)
    {
        $db = Database::instance();
        $statement = $db->prepare("SELECT * FROM users WHERE username=?");
        $statement->execute([$username]);

        $result = $statement->fetchObject(User::class);
        if ( !empty($result) ) return $result;
        return null;
    }
}