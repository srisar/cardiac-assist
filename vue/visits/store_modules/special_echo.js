export const visitSpecialEcho = {
    state: {

        visitEcho: {
            id: undefined,
            visit_id: undefined,
            param_la_systolic_diameter: 0,
            param_aortic_root_diameter: 0,
            param_lvot_diameter: 0,
            param_ivs_diastolic_thickness: 0,
            param_pw_diastolic_thickness: 0,
            param_lvid_diastole: 0,
            param_lvid_systole: 0,
            param_fractional_shortening: 0,
            param_lvef: 0,
            param_rvid: 0,
            param_peak_aortic_velocity: 0,
            param_peak_lvot_velocity: 0,
            param_aortic_lvot_velocity: 0,
            param_peak_aortic_gradient: 0,
            param_mean_aortic_gradient: 0,
            param_aortic_valve_area: 0,
            param_mitral_pressure: 0,
            param_mean_mitral_gradient: 0,
            param_mitral_valve_area: 0,
            param_peak_tricuspid_velocity: 0,
            param_stroke_volume: 0,
            param_cardiac_output: 0,
            param_cardiac_index: 0,
            param_bp: 0,
            param_hr: 0,
            param_est_rvsp: 0,
            param_est_cvp: 0,
            param_est_pasp: 0,
        },
    },
    /* --state-- */

    getters: {

        getVisitEcho(state) {
            return state.visitEcho;
        },

    },
    /* --getters-- */

    actions: {

        /* fetch */
        async visitEcho_fetch(context, visitId) {

            try {
                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-echo.php`, {visit_id: visitId});
                context.state.visitEcho = response.data;

            } catch (e) {
                throw e;
            }
        },


        /* update */
        async visitEcho_update(context, params) {
            try {
                await $.post(`${getSiteURL()}/api/update/visit/visit-echo.php`, params);
            } catch (e) {
                throw e;
            }
        },

    },
    /* --actions-- */
};
