<?php


namespace App\Models\Visit;


use App\Core\Database\Database;
use App\Models\IModel;

class VisitEchocardiography implements IModel
{

    private const TABLE = "visit_echocardiography";

    public ?int $id, $visit_id;

    public ?float $param_la_systolic_diameter, $param_aortic_root_diameter, $param_lvot_diameter, $param_ivs_diastolic_thickness,
        $param_pw_diastolic_thickness, $param_lvid_diastole, $param_lvid_systole, $param_fractional_shortening, $param_lvef,
        $param_peak_aortic_velocity, $param_peak_lvot_velocity, $param_aortic_lvot_velocity, $param_peak_aortic_gradient,
        $param_mean_aortic_gradient, $param_aortic_valve_area, $param_mitral_pressure, $param_mean_mitral_gradient,
        $param_peak_tricuspid_velocity, $param_stroke_volume, $param_cardiac_output, $param_cardiac_index,
        $param_bp, $param_hr, $param_est_rvsp, $param_est_cvp, $param_est_pasp, $param_rvid, $param_la_area, $param_asd_size,
        $param_trace_mitral_valve_area, $param_mv_score, $param_arpht, $param_aorta_root, $param_aorta_annulus, $param_aorta_st_junction,
        $param_aorta_proximal, $param_aorta_aortic_arch, $param_tapse, $param_mpa, $param_rvot1, $param_rvot2, $param_rvotat,
        $param_rv_size, $param_rv_ivg, $param_pv_pg, $param_pv_annulus, $param_dd_a, $param_dd_e, $param_dd_e_bar,
        $param_doppler_mitral_valve_area;


    public $has_diastolic_dysfunction, $is_left_atrium_dilated, $has_asd, $has_mitral_stenosis, $is_diseased_aortic_valve,
        $is_diseased_aorta, $has_vsd, $has_ps, $show_advanced;

    public ?Visit $visit;

    /**
     * @param $array
     * @return VisitEchocardiography
     */
    public static function build( $array ): VisitEchocardiography
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find( int $id ): ?VisitEchocardiography
    {
        /** @var VisitEchocardiography $result */
        $result = Database::find( self::TABLE, $id, self::class );

        return self::processData( $result );
    }

    public static function findAll( $limit = 1000, $offset = 0 ): array
    {
        return Database::findAll( self::TABLE, $limit, $offset, self::class, "visit_id" );
    }

    public function insert(): int
    {
        $data = [
            "visit_id" => $this->visit_id
        ];
        return Database::insert( self::TABLE, $data );
    }

    public function update(): bool
    {
        $data = [

            /* left ventricle */
            "param_bp" => $this->param_bp,
            "param_cardiac_output" => $this->param_cardiac_output,
            "param_cardiac_index" => $this->param_cardiac_index,
            "param_dd_a" => $this->param_dd_a,
            "param_dd_e" => $this->param_dd_e,
            "param_dd_e_bar" => $this->param_dd_e_bar,
            "param_fractional_shortening" => $this->param_fractional_shortening,
            "param_hr" => $this->param_hr,
            "param_ivs_diastolic_thickness" => $this->param_ivs_diastolic_thickness,
            "param_lvef" => $this->param_lvef,
            "param_lvid_systole" => $this->param_lvid_systole,
            "param_lvid_diastole" => $this->param_lvid_diastole,
            "param_pw_diastolic_thickness" => $this->param_pw_diastolic_thickness,
            "param_stroke_volume" => $this->param_stroke_volume,


            /* left atrium */
            "param_asd_size" => $this->param_asd_size,
            "param_la_area" => $this->param_la_area,
            "param_la_systolic_diameter" => $this->param_la_systolic_diameter,

            /* mitral valve */
            "param_doppler_mitral_valve_area" => $this->param_doppler_mitral_valve_area,
            "param_mean_mitral_gradient" => $this->param_mean_mitral_gradient,
            "param_mitral_pressure" => $this->param_mitral_pressure,
            "param_mv_score" => $this->param_mv_score,
            "param_trace_mitral_valve_area" => $this->param_trace_mitral_valve_area,

            /* aortic valve */
            "param_aortic_valve_area" => $this->param_aortic_valve_area,
            "param_aortic_lvot_velocity" => $this->param_aortic_lvot_velocity,
            "param_arpht" => $this->param_arpht,
            "param_lvot_diameter" => $this->param_lvot_diameter,
            "param_mean_aortic_gradient" => $this->param_mean_aortic_gradient,
            "param_peak_aortic_gradient" => $this->param_peak_aortic_gradient,
            "param_peak_aortic_velocity" => $this->param_peak_aortic_velocity,
            "param_peak_lvot_velocity" => $this->param_peak_lvot_velocity,

            /* aorta */
            "param_aortic_root_diameter" => $this->param_aortic_root_diameter,
            "param_aorta_root" => $this->param_aorta_root,
            "param_aorta_annulus" => $this->param_aorta_annulus,
            "param_aorta_st_junction" => $this->param_aorta_st_junction,
            "param_aorta_proximal" => $this->param_aorta_proximal,
            "param_aorta_aortic_arch" => $this->param_aorta_aortic_arch,

            /* right ventricle / pulmonary artery */
            "param_est_rvsp" => $this->param_est_rvsp,
            "param_est_cvp" => $this->param_est_cvp,
            "param_est_pasp" => $this->param_est_pasp,
            "param_mpa" => $this->param_mpa,
            "param_peak_tricuspid_velocity" => $this->param_peak_tricuspid_velocity,
            "param_rvot1" => $this->param_rvot1,
            "param_rvot2" => $this->param_rvot2,
            "param_rvotat" => $this->param_rvotat,
            "param_rv_size" => $this->param_rv_size,
            "param_rv_ivg" => $this->param_rv_ivg,
            "param_rvid" => $this->param_rvid,
            "param_tapse" => $this->param_tapse,

            /* pulmonic valve */
            "param_pv_pg" => $this->param_pv_pg,
            "param_pv_annulus" => $this->param_pv_annulus,

            "show_advanced" => $this->show_advanced ? "Y" : "N",
            "has_diastolic_dysfunction" => $this->has_diastolic_dysfunction ? "Y" : "N",
            "is_left_atrium_dilated" => $this->is_left_atrium_dilated ? "Y" : "N",
            "has_asd" => $this->has_asd ? "Y" : "N",
            "has_mitral_stenosis" => $this->has_mitral_stenosis ? "Y" : "N",
            "is_diseased_aortic_valve" => $this->is_diseased_aortic_valve ? "Y" : "N",
            "is_diseased_aorta" => $this->is_diseased_aorta ? "Y" : "N",
            "has_vsd" => $this->has_vsd ? "Y" : "N",
            "has_ps" => $this->has_ps ? "Y" : "N",
        ];

        return Database::update( self::TABLE, $data, [ "id" => $this->id ] );
    }

    /**
     * Delete from database
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete( self::TABLE, "id", $this->id );
    }

    /**
     * @param Visit $visit
     * @return VisitEchocardiography|null
     */
    public static function findByVisit( Visit $visit ): ?VisitEchocardiography
    {
        $db = Database::instance();
        $statement = $db->prepare( "select * from visit_echocardiography where visit_id=? limit 1" );
        $statement->execute( [ $visit->id ] );

        /** @var VisitEchocardiography $result */
        $result = $statement->fetchObject( self::class );

        return self::processData( $result );
    }


    private static function processData( self $data ): ?VisitEchocardiography
    {

        if ( !empty( $data ) ) {
            $data->visit = Visit::find( $data->visit_id );

            /* set boolean values */
            $data->has_diastolic_dysfunction = $data->has_diastolic_dysfunction == "Y";
            $data->is_left_atrium_dilated = $data->is_left_atrium_dilated == "Y";
            $data->has_asd = $data->has_asd == "Y";
            $data->has_mitral_stenosis = $data->has_mitral_stenosis == "Y";
            $data->is_diseased_aortic_valve = $data->is_diseased_aortic_valve == "Y";
            $data->is_diseased_aorta = $data->is_diseased_aorta == "Y";
            $data->has_vsd = $data->has_vsd == "Y";
            $data->has_ps = $data->has_ps == "Y";
            $data->show_advanced = $data->show_advanced == "Y";

            return $data;
        }
        return null;

    }

}
