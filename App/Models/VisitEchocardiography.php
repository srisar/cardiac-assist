<?php


namespace App\Models;


use App\Core\Database\Database;

class VisitEchocardiography implements IModel
{

    private const TABLE = 'visit_echocardiography';

    public ?int $id, $visit_id;

    public ?float $param_la_systolic_diameter, $param_aortic_root_diameter, $param_lvot_diameter, $param_ivs_diastolic_thickness,
        $param_pw_diastolic_thickness, $param_lvid_diastole, $param_lvid_systole, $param_fractional_shortening, $param_lvef,
        $param_peak_aortic_velocity, $param_peak_lvot_velocity, $param_aortic_lvot_velocity, $param_peak_aortic_gradient,
        $param_mean_aortic_gradient, $param_aortic_valve_area, $param_mitral_pressure, $param_mean_mitral_gradient,
        $param_mitral_valve_area, $param_peak_tricuspid_velocity, $param_stroke_volume, $param_cardiac_output, $param_cardiac_index,
        $param_bp, $param_hr, $param_est_rvsp, $param_est_cvp, $param_est_pasp, $param_rvid;

    public ?Visit $visit;

    /**
     * @param $array
     * @return VisitEchocardiography
     */
    public static function build($array): VisitEchocardiography
    {
        $object = new self();
        foreach ( $array as $key => $value ) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function find(int $id): ?VisitEchocardiography
    {
        /** @var VisitEchocardiography $result */
        $result = Database::find(self::TABLE, $id, self::class);

        if ( !empty($result) ) {
            $result->visit = Visit::find($result->visit_id);
            return $result;
        }
        return null;
    }

    public static function findAll($limit = 1000, $offset = 0): array
    {
        return Database::findAll(self::TABLE, $limit, $offset, self::class, 'visit_id');
    }

    public function insert(): int
    {
        $data = [
            'visit_id' => $this->visit_id
        ];
        return Database::insert(self::TABLE, $data);
    }

    public function update(): bool
    {
        $data = [
            'param_la_systolic_diameter'    => $this->param_la_systolic_diameter,
            'param_aortic_root_diameter'    => $this->param_aortic_root_diameter,
            'param_lvot_diameter'           => $this->param_lvot_diameter,
            'param_ivs_diastolic_thickness' => $this->param_ivs_diastolic_thickness,
            'param_pw_diastolic_thickness'  => $this->param_pw_diastolic_thickness,
            'param_lvid_diastole'           => $this->param_lvid_diastole,
            'param_lvid_systole'            => $this->param_lvid_systole,
            'param_fractional_shortening'   => $this->param_fractional_shortening,
            'param_lvef'                    => $this->param_lvef,
            'param_rvid'                    => $this->param_rvid,
            'param_peak_aortic_velocity'    => $this->param_peak_aortic_velocity,
            'param_peak_lvot_velocity'      => $this->param_peak_lvot_velocity,
            'param_aortic_lvot_velocity'    => $this->param_aortic_lvot_velocity,
            'param_peak_aortic_gradient'    => $this->param_peak_aortic_gradient,
            'param_mean_aortic_gradient'    => $this->param_mean_aortic_gradient,
            'param_aortic_valve_area'       => $this->param_aortic_valve_area,
            'param_mitral_pressure'         => $this->param_mitral_pressure,
            'param_mean_mitral_gradient'    => $this->param_mean_mitral_gradient,
            'param_mitral_valve_area'       => $this->param_mitral_valve_area,
            'param_peak_tricuspid_velocity' => $this->param_peak_tricuspid_velocity,
            'param_stroke_volume'           => $this->param_stroke_volume,
            'param_cardiac_output'          => $this->param_cardiac_output,
            'param_cardiac_index'           => $this->param_cardiac_index,
            'param_bp'                      => $this->param_bp,
            'param_hr'                      => $this->param_hr,
            'param_est_rvsp'                => $this->param_est_rvsp,
            'param_est_cvp'                 => $this->param_est_cvp,
            'param_est_pasp'                => $this->param_est_pasp,
        ];

        return Database::update(self::TABLE, $data, ['id' => $this->id]);
    }

    /**
     * Delete from database
     * @return bool
     */
    public function delete(): bool
    {
        return Database::delete(self::TABLE, 'id', $this->id);
    }

    /**
     * @param Visit $visit
     * @return VisitEchocardiography|null
     */
    public static function findByVisit(Visit $visit): ?VisitEchocardiography
    {
        $db        = Database::instance();
        $statement = $db->prepare('select * from visit_echocardiography where visit_id=? limit 1');
        $statement->execute([$visit->id]);

        /** @var VisitEchocardiography $result */
        $result = $statement->fetchObject(self::class);

        if ( !empty($result) ) {
            $result->visit = Visit::find($result->visit_id);
            return $result;
        }
        return null;
    }
}
