<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;
use PDO;

class VisitReferralLetter implements IModel
{

    public const TABLE = "visit_referral_letters";

    public ?int $id, $visit_id;
    public ?string $letter, $title;

    public static function build($array): self
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find(int $id): ?self
    {
        return Database::find(self::TABLE, $id, self::class);
    }

    public static function findAll($limit = 1000, $offset = 0)
    {
        // TODO: Implement findAll() method.
    }

    public function insert(): int
    {
        $data = [
            "visit_id" => $this->visit_id,
            "letter" => $this->letter,
            "title" => $this->title,
        ];

        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {

        $data = [
            "letter" => $this->letter,
            "title" => $this->title,
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }

    /**
     * @param Visit $visit
     * @return VisitReferralLetter[]
     */
    public static function findByVisit(Visit $visit): array
    {
        $db = Database::instance();
        $statement = $db->prepare('select * from visit_referral_letters where visit_id=?');
        $statement->execute([$visit->id]);

        /** @var self[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!empty($result)) return $result;
        return [];

    }

}
