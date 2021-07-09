export let sectionMixins = {

    data() {
        return {
            visible: true,
        }
    },

    computed: {

        showHideIcon() {
            if ( this.visible ) {
                return "/assets/images/actions/hide.svg";
            } else {
                return "/assets/images/actions/show.svg";
            }
        },

    },

    methods: {}

};
