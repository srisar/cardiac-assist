<?php


namespace App\Models;


use App\Core\Database\Database;
use PDO;

class BookPurchase implements IModel
{

    private const TABLE = 'book_purchases';

    public ?int $id, $book_id, $supplier_id, $quantity;
    public ?float $unit_price;
    public ?string $purchase_date, $subject_name, $book_title;

    public ?Book $book;
    public ?Supplier $supplier;


    /**
     * @param $array
     * @return BookPurchase
     */
    public static function build($array): BookPurchase
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @param int $id
     * @return BookPurchase|null
     */
    public static function find(int $id): ?BookPurchase
    {
        /** @var BookPurchase $bookPurchase */
        $bookPurchase = Database::find(self::TABLE, $id, self::class);

        if ( !empty($bookPurchase) ) {
            $bookId = $bookPurchase->book_id;
            $bookPurchase->book = Book::find($bookId);

            $supplierId = $bookPurchase->supplier_id;
            $bookPurchase->supplier = Supplier::find($supplierId);

            return $bookPurchase;
        }

        return null;
    }


    /**
     * @param int $limit
     * @param int $offset
     * @return BookPurchase[]
     */
    public static function findAll($limit = 1000, $offset = 0): array
    {
        /** @var BookPurchase[] $bookPurchases */
        $bookPurchases = Database::findAll(self::TABLE, $limit, $offset, self::class, 'purchase_date');

        return self::fetchAssociatedData($bookPurchases);

    }

    /**
     * @return bool|int|null
     */
    public function insert()
    {
        $data = [
            'book_id' => $this->book_id,
            'supplier_id' => $this->supplier_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'purchase_date' => $this->purchase_date,
        ];

        return Database::insert(self::TABLE, $data);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'book_id' => $this->book_id,
            'supplier_id' => $this->supplier_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'purchase_date' => $this->purchase_date,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);

    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $db = Database::instance();
        $statement = $db->prepare('delete from ' . self::TABLE . ' where id = ?');
        return $statement->execute([$this->id]);
    }


    /**
     * @param $supplier_id
     * @param $start_date
     * @param $end_date
     * @return BookPurchase[]
     */
    public static function filter($supplier_id, $start_date, $end_date): array
    {
        $db = Database::instance();

        if ( $supplier_id == 0 ) {
            $statement = $db->prepare('select * from ' . self::TABLE . ' where purchase_date between :start_date and :end_date');

            $statement->execute([
                ':start_date' => $start_date,
                ':end_date' => $end_date,
            ]);

        } else {
            $statement = $db->prepare('select * from ' . self::TABLE . ' where supplier_id=:supplier_id and purchase_date between :start_date and :end_date');
            $statement->execute([
                ':supplier_id' => $supplier_id,
                ':start_date' => $start_date,
                ':end_date' => $end_date,
            ]);
        }

        /** @var BookPurchase[] $bookPurchases */
        $bookPurchases = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        return self::fetchAssociatedData($bookPurchases);

    }

    /**
     * @param $bookPurchases
     * @return BookPurchase[]
     */
    private static function fetchAssociatedData($bookPurchases): array
    {

        if ( !empty($bookPurchases) ) {

            $output = [];

            foreach ( $bookPurchases as $bookPurchase ) {

                $bookId = $bookPurchase->book_id;
                $bookPurchase->book = Book::find($bookId);

                $supplierId = $bookPurchase->supplier_id;
                $bookPurchase->supplier = Supplier::find($supplierId);
                $output[] = $bookPurchase;

            }

            return $output;
        }

        return [];
    }
}