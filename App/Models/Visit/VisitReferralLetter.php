<?php


namespace App\Models\Visit;


use App\Models\IModel;

class VisitReferralLetter implements IModel
{

    public const TABLE = "visit_referral_letters";

    public ?int $id, $visit_id;
    public ?string $letter;

    public static function build($array): self
    {
        $object = new self();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find(int $id)
    {
        // TODO: Implement find() method.
    }

    public static function findAll($limit = 1000, $offset = 0)
    {
        // TODO: Implement findAll() method.
    }

    public function insert()
    {
        // TODO: Implement insert() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
