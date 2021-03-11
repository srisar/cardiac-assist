export default {

    data() {
        return {
            mitralValveValueToAdd: {
                value: "",
            },

            mitralValveValueToEdit: {
                id   : undefined,
                value: "",
            },

            mitralValveValues: [],

            messages: {
                updateMessage: "",
            }
        }
    },


    /* ### MOUNTED ### */
    mounted() {

        this.fetchAll()

    }, /* MOUNTED */

    /* ### METHODS ### */
    methods: {

        /*
        * Fetch all values
        * */
        fetchAll: function () {
            $.get(`${getSiteURL()}/api/get/echo-mitral-valve-values.php`)
                .done(response => {
                    this.mitralValveValues = response.data
                })
                .fail(e => { console.log(e) })
        },

        /*
        * Save new value
        * */
        save: function () {

            const param = {
                value: this.mitralValveValueToAdd.value
            }

            $.post(`${getSiteURL()}/api/save/echo-mitral-valve-value.php`, param)
                .done(() => {
                    // fetch everything again
                    this.fetchAll()
                })
                .fail(e => { console.log(e) })

        },

        /*
        * Updates the values
        * */
        update: function () {
            const param = {
                id   : this.mitralValveValueToEdit.id,
                value: this.mitralValveValueToEdit.value,
            }

            $.post(`${getSiteURL()}/api/update/echo-mitral-valve-value.php`, param)
                .done(() => {
                    // fetch everything again
                    this.fetchAll()
                    this.messages.updateMessage = 'Updated successfully'
                })
                .fail(e => {
                    this.messages.updateMessage = 'Update failed'
                    console.log(e)
                })
        },

    }, /* METHODS */
}
