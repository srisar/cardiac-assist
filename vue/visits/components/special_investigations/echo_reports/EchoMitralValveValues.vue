<template>

  <div class="report-section">

    <div class="alert alert-dark shadow shadow-sm p-2">

      <CommonView :all-values="allValues" :visit-values="visitValues" label="Mitral Valve" @add="onAdd" @new="onNew('echo-mitral-valve-value.php')"/>

    </div>


  </div>

</template>

<script>

import mixins from "./mixins";
import CommonView from "./CommonView";

export default {
  name      : "EchoMitralValveValues",
  components: { CommonView  },
  mixins    : [mixins],

  /* ### DATA ### */
  data() {
    return {
      allValues   : [],
      visitValues : [],
      selectedItem: -1,
      REPORT_TYPE : 'echo_mitral_valve_values'

    }
  }, /* DATA */

  /* ### COMPUTED ### */
  computed: {

    visit: function () {
      return this.$store.getters.getVisit;
    },

  }, /* COMPUTED */

  /* ### MOUNTED ### */
  mounted() {

    this.fetchAllValues()
    this.fetchVisitValues()

  }, /* MOUNTED */

  /* ### METHODS ### */
  methods: {

    truncate: function (text) {
      return _.truncate(text, { length: 120 });
    },

    fetchAllValues: function () {
      $.get(`${getSiteURL()}/api/get/echo/echo-mitral-valve-values.php`)
          .done(response => {
            this.allValues = response.data
          })
          .fail(error => {
            console.log(error)
          })
    }, /* fetch all values */

  }, /* METHODS */

}
</script>

<style scoped>

</style>
