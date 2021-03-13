export default {

    data() {
        return {
            inputVisible: false,
        }
    },

    methods: {

        onNew: function (urlEndPoint) {

            bootbox.prompt({
                size    : 'large',
                title   : 'ADD A NEW REMARK',
                callback: result => {

                    if ( result == null ) return

                    result = _.trim(result)

                    if ( !_.isEmpty(result) ) {

                        const param = {
                            value: result
                        }

                        $.post(`${getSiteURL()}/api/save/${urlEndPoint}`, param)
                            .done(() => {
                                // fetch everything again
                                this.fetchAllValues()
                            })
                            .fail(e => { console.log(e) })

                    } else {
                        bootbox.alert({
                            title  : '<i class="bi bi-exclamation-circle-fill"></i> Error',
                            message: 'Empty values cannot be saved!'
                        })
                    }
                }
            })

        }, /* on new */

        /* on add */
        onAdd: function (item) {

            const params = {
                visit_id   : this.visit.id,
                value_id   : item.id,
                report_type: this.REPORT_TYPE
            }

            $.get(`${getSiteURL()}/api/save/visit-echo-report-value.php`, params)
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
                visit_id   : this.visit.id,
                report_type: this.REPORT_TYPE
            }

            $.get(`${getSiteURL()}/api/get/visit-echo-report-values.php`, params)
                .done(response => {
                    this.visitValues = response.data
                })
                .fail(() => {

                })
        }, /* fetch visit values */

        onRemove: function (item) {

            const params = {
                visit_id   : item.visit_id,
                value_id   : item.id,
                report_type: this.REPORT_TYPE
            }

            $.get(`${getSiteURL()}/api/delete/visit-echo-report-value.php`, params)
                .done(() => {
                    this.fetchVisitValues()
                })
                .fail(() => {
                    bootbox.alert('<p class="lead">Failed to remove</p>')
                })
        }, /* on remove */


    }

}
