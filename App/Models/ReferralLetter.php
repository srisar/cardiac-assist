<?php


namespace App\Models;


use App\Core\Database\Database;

class ReferralLetter implements IModel
{

    public const TABLE = "referral_letters";

    public ?int $id;
    public ?string $letter_model, $title;


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

    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, "id");
    }

    public function insert(): int
    {

        $data = [
            "letter_model" => $this->letter_model,
            "title" => $this->title
        ];

        return Database::insert(self::TABLE, $data);

    }

    public function update(): bool
    {
        $data = [
            "letter_model" => $this->letter_model,
            "title" => $this->title
        ];

        return Database::update(self::TABLE, $data, ["id" => $this->id]);
    }

    public function delete(): bool
    {
        return Database::delete(self::TABLE, "id", $this->id);
    }
}
