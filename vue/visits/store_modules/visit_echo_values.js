export default {

    state: {

        echoRemarksTypes: {
            "LEFT_VENTRICLE": "Left Ventricle",
            "LEFT_ATRIUM": "Left Atrium",
            "MITRAL_VALVE": "Mitral Valve",
            "AORTIC_VALVE": "Aortic Valve",
            "AORTA": "Aorta",
            "RIGHT_VENTRICLE": "Right Ventricle / Pulmonary Artery",
            "RIGHT_ATRIUM": "Right Atrium",
            "PULMONIC_VALVE": "Pulmonic Valve",
            "TRICUSPID": "Tricuspid",
            "PERICARDIUM": "Pericardium",
            "CONCLUSION": "Conclusion",
        },

        echoRemarks: [],

        visitEchoRemarks: [],

    },

    getters: {

        getEchoRemarks(state) {
            return state.echoRemarks
        },

        getVisitEchoRemarks(state) {
            return state.visitEchoRemarks
        },

        getEchoRemarksTypes: function (state) {
            return state.echoRemarksTypes
        },

    },

    mutations: {
        setEchoRemarks: function (state, values) {
            state.echoRemarks = values
        },

        setVisitEchoRemarks: function (state, values) {
            state.visitEchoRemarks = values
        },

    },

    actions: {

        /* fetch all remarks */
        async echo_fetchAllRemarks(context) {

            try {

                let response = await $.get(`${getSiteURL()}/api/get/echo/echo-remarks.php`);
                context.commit("setEchoRemarks", response);

            } catch (e) {
                throw e;
            }

        },


        /* fetch all visit remarks */
        async echo_fetchAllVisitRemarks(context, visit_id) {


            try {

                let response = await $.get(`${getSiteURL()}/api/get/visit/visit-echo-remarks.php`, {visit_id: visit_id});
                context.commit("setVisitEchoRemarks", response);

            } catch (e) {
                throw e;
            }


        },

        /* add a new visit remark */
        async echo_addVisitRemark(context, params) {

            try {

                await $.post(`${getSiteURL()}/api/save/visit/visit-echo-remarks.php`, params);

            } catch (e) {
                throw e;
            }

        },

        /* delete a remark */
        async echo_delete(context, id) {

            try {

                await $.post(`${getSiteURL()}/api/delete/visit/visit-echo-remarks.php`, {id: id});

            } catch (e) {
                throw e;
            }

        },

        /* add a new echo remark */
        async echo_addEchoRemark(context, params) {

            try {

                await $.post(`${getSiteURL()}/api/save/echo/echo-remarks.php`, params);

            } catch (e) {
                throw e;
            }

        },/* save new echo remark */

    },

}
