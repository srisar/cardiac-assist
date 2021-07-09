export const visitSpecialEcho = {
    state: {

        visitEcho: {
            id: null,
            visit_id: null,

            /* left ventricle */
            param_ivs_diastolic_thickness: "",
            param_lvid_diastole: "",
            param_pw_diastolic_thickness: "",
            param_lvid_systole: "",
            param_fractional_shortening: "",
            param_bp: "",
            param_hr: "",
            param_dd_a: "",
            param_dd_e: "",
            param_dd_e_bar: "",
            param_stroke_volume: "",
            param_cardiac_output: "",
            param_cardiac_index: "",
            param_lvef: "",

            /* left atrium */
            param_la_systolic_diameter: "",
            param_la_area: "",
            param_asd_size: "",

            /* mitral valve */
            param_mitral_pressure: "",
            param_mean_mitral_gradient: "",
            param_trace_mitral_valve_area: "",
            param_doppler_mitral_valve_area: "",
            param_mv_score: "",


            /* aortic valve */
            param_mean_aortic_gradient: "",
            param_peak_aortic_velocity: "",
            param_aortic_lvot_velocity: "",
            param_lvot_diameter: "",
            param_peak_lvot_velocity: "",
            param_peak_aortic_gradient: "",
            param_aortic_valve_area: "",
            param_arpht: "",

            /* aorta */
            param_aortic_root_diameter: "",
            param_aorta_root: "",
            param_aorta_annulus: "",
            param_aorta_st_junction: "",
            param_aorta_proximal: "",
            param_aorta_aortic_arch: "",

            /* right ventricle / pulmonary artery */
            param_peak_tricuspid_velocity: "",
            param_rvid: "",
            param_tapse: "",
            param_mpa: "",
            param_rvot1: "",
            param_rvot2: "",
            param_rvotat: "",
            param_est_rvsp: "",
            param_est_cvp: "",
            param_est_pasp: "",
            param_rv_size: "",
            param_rv_ivg: "",

            /* pulmonic valve */
            param_pv_pg: "",
            param_pv_annulus: "",

            show_advanced: false,
            has_diastolic_dysfunction: false,
            is_left_atrium_dilated: false,
            has_asd: false,
            has_vsd: false,
            has_ps: false,
            has_aorta: false,
            has_right_ventricle: false,
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
