export default {

    data() {
        return {
            inputVisible: false,
        }
    },

    computed: {
        visitId: function () {
            return this.$store.getters.getVisitId;
        },
    },

    methods: {

        onNew: function (urlEndPoint) {

            bootbox.prompt({
                size: 'large',
                title: 'ADD A NEW REMARK',
                callback: result => {

                    if (result == null) return

                    result = _.trim(result)

                    if (!_.isEmpty(result)) {

                        const param = {
                            value: result
                        }

                        $.post(`${getSiteURL()}/api/save/echo/${urlEndPoint}`, param)
                            .done(() => {
                                // fetch everything again
                                this.fetchAllValues()
                            })
                            .fail(e => {
                                console.log(e)
                            })

                    } else {
                        errorMessage('Empty value cannot be saved')
                    }
                }
            })

        }, /* on new */

        /* on add */
        onAdd: function (payload) {

            const params = {
                visit_id: this.visitId,
                value_id: payload.item.id,
                report_type: this.REPORT_TYPE
            }

            $.get(`${getSiteURL()}/api/save/visit/visit-echo-report-value.php`, params)
                .done(() => {
                    this.fetchVisitValues()
                    this.selectedItem = -1
                })
                .fail(() => {
                    bootbox.alert('<p class="lead">Failed to add</p><p>Please select a valid option</p>')
                })

        }, /* on add*/


        fetchVisitValues: function () {
            const params = {
                visit_id: this.visitId,
                report_type: this.REPORT_TYPE
            }

            $.get(`${getSiteURL()}/api/get/visit/visit-echo-report-values.php`, params)
                .done(response => {
                    this.visitValues = response.data
                })
                .fail(() => {

                })
        }, /* fetch visit values */

        onRemove: function (payload) {

            const params = {
                visit_id: payload.item.visit_id,
                value_id: payload.item.id,
                report_type: this.REPORT_TYPE
            }

            $.get(`${getSiteURL()}/api/delete/visit/visit-echo-report-value.php`, params)
                .done(() => {
                    this.fetchVisitValues()
                })
                .fail(() => {
                    bootbox.alert('<p class="lead">Failed to remove</p>')
                })
        }, /* on remove */


    }

}
