export default {

    state: {

        echoRemarksTypes: {
            'LEFT_VENTRICLE': 'Left Ventricle',
            'LEFT_ATRIUM': 'Left Atrium',
            'MITRAL_VALVE': 'Mitral Valve',
            'AORTIC_VALVE': 'Aortic Valve',
            'AORTA': 'Aorta',
            'RIGHT_VENTRICLE': 'Right Ventricle / Pulmonary Artery',
            'RIGHT_ATRIUM': 'Right Atrium',
            'PULMONIC_VALVE': 'Pulmonic Valve',
            'TRICUSPID': 'Tricuspid',
            'PERICARDIUM': 'Pericardium',
            'CONCLUSION': 'Conclusion',
        },

        echoRemarks: [],

        visitEchoRemarks: [],

    },

    getters: {

        getEchoRemarks( state ) {
            return state.echoRemarks;
        },

        getVisitEchoRemarks( state ) {
            return state.visitEchoRemarks;
        },

        getEchoRemarksTypes: function ( state ) {
            return state.echoRemarksTypes;
        },

    },

    mutations: {
        setEchoRemarks: function ( state, values ) {
            state.echoRemarks = values;
        },

        setVisitEchoRemarks: function ( state, values ) {
            state.visitEchoRemarks = values;
        },

    },

    actions: {

        /* fetch all remarks */
        async echo_fetchAllRemarks( context ) {

            let response = await $.get( `${ getSiteURL() }/api/get/echo/echo-remarks.php` );
            context.commit( 'setEchoRemarks', response );

        },


        /* fetch all visit remarks */
        async echo_fetchAllVisitRemarks( context, visit_id ) {
            let response = await $.get( `${ getSiteURL() }/api/get/visit/visit-echo-remarks.php`, { visit_id: visit_id } );
            context.commit( 'setVisitEchoRemarks', response );


        },

        /* add a new visit remark */
        async echo_addVisitRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/visit/visit-echo-remarks.php`, params );

        },

        /* delete a remark */
        async echo_deleteVisitRemark( context, id ) {
            await $.post( `${ getSiteURL() }/api/delete/visit/visit-echo-remarks.php`, { id: id } );
        },

        /* add a new echo remark */
        async echo_addEchoRemark( context, params ) {
            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, params );
        },/* save new echo remark */


        /*
         * ----------------------------------------------------------------------------------------------------------
         * -------------------
         * search echo remarks
         * -------------------
         * ----------------------------------------------------------------------------------------------------------
         */

        /* search left ventricle remarks */
        /**
         *
         * @param context
         * @param query
         */
        async echo_searchLeftVentricleRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'LEFT_VENTRICLE',
            } );
            return response[ 'data' ];
        },

        async echo_searchLeftAtriumRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'LEFT_ATRIUM',
            } );
            return response[ 'data' ];
        },

        async echo_searchMitralValveRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'MITRAL_VALVE',
            } );
            return response[ 'data' ];
        },

        async echo_searchAorticValveRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'AORTIC_VALVE',
            } );
            return response[ 'data' ];
        },

        async echo_searchAortaValveRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'AORTA',
            } );
            return response[ 'data' ];
        },

        async echo_searchRightVentricleRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'RIGHT_VENTRICLE',
            } );
            return response[ 'data' ];
        },

        async echo_searchRightAtriumRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'RIGHT_ATRIUM',
            } );
            return response[ 'data' ];
        },

        async echo_searchPulmonicValveRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'PULMONIC_VALVE',
            } );
            return response[ 'data' ];
        },

        async echo_searchTricuspidRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'TRICUSPID',
            } );
            return response[ 'data' ];
        },

        async echo_searchPericardiumRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'PERICARDIUM',
            } );
            return response[ 'data' ];
        },

        async echo_searchConclusionRemarks( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/echo-remarks/remarks.php`, {
                query: query,
                type: 'CONCLUSION',
            } );
            return response[ 'data' ];
        },


        /*
         * ----------------------------------------------------------------------------------------------------------
         * -------------------
         * add echo remarks
         * -------------------
         * ----------------------------------------------------------------------------------------------------------
         */
        async echo_addLeftVentricleRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'LEFT_VENTRICLE',
            } );
        },/* save new echo remark */

        async echo_addLeftAtriumRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'LEFT_ATRIUM',
            } );
        },/* save new echo remark */

        async echo_addMitralValveRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'MITRAL_VALVE',
            } );
        },/* save new echo remark */

        async echo_addAorticValveRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'AORTIC_VALVE',
            } );
        },/* save new echo remark */

        async echo_addAortaRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'AORTA',
            } );
        },/* save new echo remark */

        async echo_addRightVentricleRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'RIGHT_VENTRICLE',
            } );
        },/* save new echo remark */

        async echo_addRightAtriumRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'RIGHT_ATRIUM',
            } );
        },/* save new echo remark */

        async echo_addPulmonicValveRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'PULMONIC_VALVE',
            } );
        },/* save new echo remark */

        async echo_addTricuspidRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'TRICUSPID',
            } );
        },/* save new echo remark */

        async echo_addPericardiumRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'PERICARDIUM',
            } );
        },/* save new echo remark */

        async echo_addConclusionRemark( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/echo/echo-remarks.php`, {
                value: params[ 'value' ],
                type: 'CONCLUSION',
            } );
        },/* save new echo remark */

    },

};
