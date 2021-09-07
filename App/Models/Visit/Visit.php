<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;
use App\Models\Patient;
use PDO;
use PDOException;

class Visit implements IModel
{

    private const TABLE = "visits";

    public ?int $id, $patient_id, $heart_beat;

    public ?string $visit_date, $remarks, $review_in, $other_remarks;

    public ?float $weight, $height, $bmi, $bsa, $dbp, $sbp, $ef;

    public ?bool $dm, $ht, $dl;

    public ?string $smoking, $family_history, $status;

    public ?Patient $patient;


    private const STATUS_COMPLETE = "COMPLETE";
    private const STATUS_INCOMPLETE = "INCOMPLETE";

    public static function build( $array ): Visit
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return Visit|null
     */
    public static function find( int $id ): ?Visit
    {
        /** @var Visit $visit */
        $visit = Database::find( self::TABLE, $id, self::class );

        if ( !empty( $visit ) ) {
            $visit->patient = Patient::find( $visit->patient_id );
        }

        return $visit;

    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function findAll( $limit = 1000, $offset = 0 ): array
    {
        return Database::findAll( self::TABLE, $limit, $offset, self::class, "patient_id" );
    }


    public function insert(): bool
    {
        $db = Database::instance();

        try {

            $data = [
                "patient_id" => $this->patient_id,
                "visit_date" => $this->visit_date,
                "remarks" => $this->remarks,
                "height" => $this->height,
                "weight" => $this->weight,
                "bmi" => $this->bmi,
                "bsa" => $this->bsa,
                "sbp" => $this->sbp,
                "dbp" => $this->dbp,
                "dm" => $this->dm ? 1 : 0,
                "ht" => $this->ht ? 1 : 0,
                "dl" => $this->dl ? 1 : 0,
                "ef" => $this->ef,
                "heart_beat" => $this->heart_beat,
            ];

            $db->beginTransaction();

            $visitId = Database::insert( self::TABLE, $data );

            if ( $visitId != -1 ) {
                $visitECG = new VisitECG();
                $visitECG->visit_id = $visitId;
                $visitECG->insert();

                $visitCCT = new VisitCoronaryCT();
                $visitCCT->visit_id = $visitId;
                $visitCCT->insert();

                $visitLipids = new VisitLipid();
                $visitLipids->visit_id = $visitId;
                $visitLipids->insert();

                $visitEcho = new VisitEchocardiography();
                $visitEcho->visit_id = $visitId;
                $visitEcho->insert();

                $visitAngio = new VisitAngiography();
                $visitAngio->visit_id = $visitId;
                $visitAngio->insert();
            }

            $db->commit();

            return true;

        } catch ( PDOException $exception ) {
            error_log( $exception->getMessage() );
            $db->rollBack();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            "visit_date" => $this->visit_date,
            "remarks" => $this->remarks,
            "height" => $this->height,
            "weight" => $this->weight,
            "bmi" => $this->bmi,
            "bsa" => $this->bsa,
            "sbp" => $this->sbp,
            "dbp" => $this->dbp,
            "dm" => $this->dm ? 1 : 0,
            "ht" => $this->ht ? 1 : 0,
            "dl" => $this->dl ? 1 : 0,
            "ef" => $this->ef,
            "smoking" => $this->smoking,
            "family_history" => $this->family_history,
            "heart_beat" => $this->heart_beat,
        ];

        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );
    }

    /**
     *
     * @return bool
     */
    public function setAsComplete(): bool
    {
        $data = [
            "status" => self::STATUS_COMPLETE,
        ];
        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );
    }

    /**
     * @return bool
     */
    public function setAsIncomplete(): bool
    {
        $data = [
            "status" => self::STATUS_INCOMPLETE,
        ];
        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );
    }

    /**
     * Delete a visit: will remove all the associated diagnosis, symptoms and all other
     * data with it
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete( self::TABLE, "id", $this->id );
    }


    /**
     * @param Patient $patient
     * @return Visit[]
     */
    public static function findByPatient( Patient $patient ): array
    {
        $db = Database::instance();
        $statement = $db->prepare( "select * from visits where patient_id=?" );
        $statement->execute( [ $patient->id ] );

        $results = $statement->fetchAll( PDO::FETCH_CLASS, self::class );

        if ( !empty( $results ) ) return $results;
        return [];

    }

    /**
     *  Update review in date value
     * @return bool
     */
    public function updateReviewIn(): bool
    {
        $data = [
            "review_in" => $this->review_in,
        ];
        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );

    }

    public function updateOtherRemarks(): bool
    {
        $data = [
            "other_remarks" => $this->other_remarks,
        ];

        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );
    }


}
