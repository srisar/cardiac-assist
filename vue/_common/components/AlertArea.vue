<template>

  <div class="alert my-2" :class="className" v-if="message">
    {{ message }}
  </div>

</template>

<script>

import {TYPE_ERROR, TYPE_INFO, TYPE_SUCCESS, TYPE_WARNING} from "../message_types";


export default {
  name: "AlertArea",
  props: {
    feedback: Object,
    trigger: Boolean,
  },

  data() {
    return {
      message: this.feedback.message,
      type: this.feedback.type,
    }
  },

  computed: {
    className() {

      if ( this.type === TYPE_ERROR ) return 'alert-danger';
      if ( this.type === TYPE_INFO ) return 'alert-info';
      if ( this.type === TYPE_WARNING ) return 'alert-warning';
      if ( this.type === TYPE_SUCCESS ) return 'alert-success';

      return 'alert-primary';
    },

  },

  watch: {

    // deep change watcher
    // https://vuejs.org/v2/api/#watch
    feedback: {
      handler: function ( newFeedback ) {

        this.message = newFeedback.message;
        this.type = newFeedback.type;

        setTimeout( () => {
          this.message = "";
          this.$emit( "clear" );
        }, 3000 );

      },
      deep: true
    }

  },

  mounted() {


  }


}
</script>

<style scoped>

</style>
