export const visitSpecialEcho = {
    state: {

        visitEcho: {
            id: null,
            visit_id: null,

            /* left ventricle */
            param_ivs_diastolic_thickness: 0,
            param_lvid_diastole: 0,
            param_pw_diastolic_thickness: 0,
            param_lvid_systole: 0,
            param_fractional_shortening: 0,
            param_bp: 0,
            param_hr: 0,
            param_dd_a: 0,
            param_dd_e: 0,
            param_dd_e_bar: 0,
            param_stroke_volume: 0,
            param_cardiac_output: 0,
            param_cardiac_index: 0,
            param_lvef: 0,

            /* left atrium */
            param_la_systolic_diameter: 0,
            param_la_area: 0,
            param_asd_size: 0,

            /* mitral valve */
            param_mitral_pressure: 0,
            param_mean_mitral_gradient: 0,
            param_trace_mitral_valve_area: 0,
            param_doppler_mitral_valve_area: 0,
            param_mv_score: 0,


            /* aortic valve */
            param_mean_aortic_gradient: 0,
            param_peak_aortic_velocity: 0,
            param_aortic_lvot_velocity: 0,
            param_lvot_diameter: 0,
            param_peak_lvot_velocity: 0,
            param_peak_aortic_gradient: 0,
            param_aortic_valve_area: 0,
            param_arpht: 0,

            /* aorta */
            param_aortic_root_diameter: 0,
            param_aorta_root: 0,
            param_aorta_annulus: 0,
            param_aorta_st_junction: 0,
            param_aorta_proximal: 0,
            param_aorta_aortic_arch: 0,

            /* right ventricle / pulmonary artery */
            param_peak_tricuspid_velocity: 0,
            param_rvid: 0,
            param_tapse: 0,
            param_mpa: 0,
            param_rvot1: 0,
            param_rvot2: 0,
            param_rvotat: 0,
            param_est_rvsp: 0,
            param_est_cvp: 0,
            param_est_pasp: 0,
            param_rv_size: 0,
            param_rv_ivg: 0,

            /* pulmonic valve */
            param_pv_pg: 0,
            param_pv_annulus: 0,

            show_advanced: false,
            has_diastolic_dysfunction: false,
            is_left_atrium_dilated: false,
            has_asd: false,
            has_vsd: false,
            has_ps: false,
            has_mitral_stenosis: false,
            is_diseased_aortic_valve: false,
            is_diseased_aorta: false,
        },
    },
    /* --state-- */

    getters: {

        getVisitEcho( state ) {
            return state.visitEcho;
        },

    },
    /* --getters-- */

    actions: {

        /* fetch */
        async visitEcho_fetch( context, visitId ) {

            try {
                const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-echo.php`, { visit_id: visitId } );
                context.state.visitEcho = response.data;

            } catch ( e ) {
                throw e;
            }
        },


        /* update */
        async visitEcho_update( context, params ) {
            try {
                await $.post( `${ getSiteURL() }/api/update/visit/visit-echo.php`, params );
            } catch ( e ) {
                throw e;
            }
        },

    },
    /* --actions-- */
};
