<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class Book implements IModel
{

    private const TABLE = 'books';

    public ?int $id, $subject_id;
    public ?string $book_title, $subject_name;

    public ?Subject $subject;


    /**
     * @param $array
     * @return Book
     */
    public static function build($array): Book
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
    public static function find(int $id): ?Book
    {
        /** @var Book $book */
        $book = Database::find(self::TABLE, $id, self::class);

        if ( !empty($book) ) {

            $subject = Subject::find($book->subject_id);
            $book->subject = $subject;

            return $book;

        }
        return null;

    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Book[]|null
     */
    public static function findAll($limit = 1000, $offset = 0): ?array
    {
        /** @var Book[] $books */
        $books = Database::findAll(self::TABLE, $limit, $offset, self::class, 'book_title');

        if ( !empty($books) ) {

            $booksList = [];

            foreach ( $books as $book ) {
                $subject = Subject::find($book->subject_id);
                $book->subject = $subject;
                $booksList[] = $book;
            }

            return $booksList;
        }

        return null;

    }


    /**
     * @return bool|int|null
     */
    public function insert()
    {
        $data = [
            'book_title' => $this->book_title,
            'subject_id' => $this->subject_id
        ];

        return Database::insert(self::TABLE, $data);

    }


    public function update(): bool
    {
        $data = [
            'book_title' => $this->book_title,
            'subject_id' => $this->subject_id
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    /**
     * @param $book_title
     * @return Book|null
     */
    public static function getBookByTitle($book_title): ?Book
    {
        $db = Database::instance();
        $statement = $db->prepare('SELECT * FROM ' . self::TABLE . ' WHERE book_title=?');
        $statement->execute([$book_title]);

        $data = $statement->fetchObject(self::class);
        if ( !empty($data) ) return $data;
        return null;
    }

    /**
     * @param Book $book
     * @return bool
     */
    public static function alreadyExists(Book $book): bool
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from books b where b.book_title = ? and b.subject_id = ?');

        $statement->execute([$book->book_title, $book->subject_id]);

        $data = $statement->fetchObject(self::class);

        if ( !empty($data) ) return true;
        return false;
    }


    /**
     * @param $query
     * @return Book[]|null
     */
    public static function search($query): ?array
    {
        $db = Database::instance();

        $statement = $db->prepare('
        select b.id as id, b.book_title as book_title, b.subject_id as subject_id, s.subject_name as subject_name from books b 
            join subjects s 
            on b.subject_id = s.id and b.book_title like :query
        ');

        $statement->execute([
            ':query' => '%' . $query . '%'
        ]);

        $data = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if ( !empty($data) ) return $data;
        return null;

    }


}