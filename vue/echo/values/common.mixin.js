export default {
    data() {
        return {
            modalEditWindowVisible: false,
            confirmDelete         : false,

            toAdd: {
                value: "",
            },

            toEdit: {
                id   : undefined,
                value: "",
            },

            values: [],
        }
    },


    computed: {
        isEmptyList: function () {
            return _.isEmpty(this.values)
        },
    },

    methods: {
        isEmptyValue: function (value) {
            return _.isEmpty(value)
        },

        openEditModal: function (item) {
            this.toEdit = _.cloneDeep(item)
            this.modalEditWindowVisible = true
        },

        closeEditModal: function () {
            this.modalEditWindowVisible = false
        },
    },

}
