<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;

class VisitAngiography implements IModel
{

    private const TABLE = 'visit_angiography';

    public ?int $id, $visit_id;
    public ?string $instruments, $dominance_left, $dominance_right, $notes,
        $prox_rca_lesion_type, $prox_rca_timi_flow,
        $mid_rca_lesion_type, $mid_rca_timi_flow,
        $rpl1_lesion_type, $rpl1_timi_flow,
        $rpl2_lesion_type, $rpl2_timi_flow,
        $mid_lad_lesion_type, $mid_lad_timi_flow,
        $dist_lad_lesion_type, $dist_lad_timi_flow,
        $left_main_lesion_type, $left_main_timi_flow,
        $left_circumflex_lesion_type, $left_circumflex_timi_flow,
        $prox_lad_lesion_type, $prox_lad_timi_flow,
        $om1_lesion_type, $om1_timi_flow,
        $om2_lesion_type, $om2_timi_flow,
        $pda_lesion_type, $pda_timi_flow;

    public ?int $prox_rca_stenosis, $mid_rca_stenosis, $rpl1_stenosis, $rpl2_stenosis, $mid_lad_stenosis,
        $dist_lad_stenosis, $left_main_stenosis, $left_circumflex_stenosis, $prox_lad_stenosis,
        $om1_stenosis, $om2_stenosis, $pda_stenosis;


    public ?Visit $visit;


    /**
     * @param $array
     * @return VisitAngiography
     */
    public static function build( $array ): VisitAngiography
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }


    /**
     * @param int $id
     * @return VisitAngiography|null
     */
    public static function find( int $id ): ?VisitAngiography
    {
        /** @var VisitAngiography $result */
        $result = Database::find( self::TABLE, $id, self::class );

        if ( !empty( $result ) ) {
            $result->visit = Visit::find( $result->visit_id );
            return $result;
        }
        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return VisitAngiography[]
     */
    public static function findAll( $limit = 1000, $offset = 0 ): array
    {
        return Database::findAll( self::TABLE, $limit, $offset, self::class, 'visit_id' );
    }


    public function insert(): int
    {
        $data = [
            'visit_id' => $this->visit_id
        ];
        return Database::insert( self::TABLE, $data );
    }


    /**
     *
     * @return bool
     */
    public function update(): bool
    {
        $data = [
            'instruments' => $this->instruments,
            'notes' => $this->notes,
            'dominance_left' => $this->dominance_left ? 1 : 0,
            'dominance_right' => $this->dominance_right ? 1 : 0,

            'prox_rca_stenosis' => $this->prox_rca_stenosis,
            'prox_rca_lesion_type' => $this->prox_rca_lesion_type,
            'prox_rca_timi_flow' => $this->prox_rca_timi_flow,

            'prox_lad_stenosis' => $this->prox_lad_stenosis,
            'prox_lad_lesion_type' => $this->prox_lad_lesion_type,
            'prox_lad_timi_flow' => $this->prox_lad_timi_flow,

            'mid_rca_stenosis' => $this->mid_rca_stenosis,
            'mid_rca_lesion_type' => $this->mid_rca_lesion_type,
            'mid_rca_timi_flow' => $this->mid_rca_timi_flow,

            'rpl1_stenosis' => $this->rpl1_stenosis,
            'rpl1_lesion_type' => $this->rpl1_lesion_type,
            'rpl1_timi_flow' => $this->rpl1_timi_flow,

            'rpl2_stenosis' => $this->rpl2_stenosis,
            'rpl2_lesion_type' => $this->rpl2_lesion_type,
            'rpl2_timi_flow' => $this->rpl2_timi_flow,

            'mid_lad_stenosis' => $this->mid_lad_stenosis,
            'mid_lad_lesion_type' => $this->mid_lad_lesion_type,
            'mid_lad_timi_flow' => $this->mid_lad_timi_flow,

            'dist_lad_stenosis' => $this->dist_lad_stenosis,
            'dist_lad_lesion_type' => $this->dist_lad_lesion_type,
            'dist_lad_timi_flow' => $this->dist_lad_timi_flow,

            'left_main_stenosis' => $this->left_main_stenosis,
            'left_main_lesion_type' => $this->left_main_lesion_type,
            'left_main_timi_flow' => $this->left_main_timi_flow,

            'left_circumflex_stenosis' => $this->left_circumflex_stenosis,
            'left_circumflex_lesion_type' => $this->left_circumflex_lesion_type,
            'left_circumflex_timi_flow' => $this->left_circumflex_timi_flow,

            'om1_stenosis' => $this->om1_stenosis,
            'om1_lesion_type' => $this->om1_lesion_type,
            'om1_timi_flow' => $this->om1_timi_flow,

            'om2_stenosis' => $this->om2_stenosis,
            'om2_lesion_type' => $this->om2_lesion_type,
            'om2_timi_flow' => $this->om2_timi_flow,

            'pda_stenosis' => $this->pda_stenosis,
            'pda_lesion_type' => $this->pda_lesion_type,
            'pda_timi_flow' => $this->pda_timi_flow,
        ];

        return Database::update( self::TABLE, $data, [ 'id' => $this->id ] );

    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete( self::TABLE, 'id', $this->id );
    }


    /**
     * @param Visit $visit
     * @return VisitAngiography|null
     */
    public static function findByVisit( Visit $visit ): ?VisitAngiography
    {
        $db = Database::instance();
        $statement = $db->prepare( 'select * from visit_angiography where visit_id=? limit 1' );
        $statement->execute( [ $visit->id ] );

        /** @var VisitAngiography $result */
        $result = $statement->fetchObject( self::class );

        if ( !empty( $result ) ) {
            $result->visit = Visit::find( $result->visit_id );
            return $result;
        }
        return null;

    }

}
