<template>

  <div class="report-section">

    <div class="alert alert-dark shadow shadow-sm p-2">

      <CommonView :all-values="allValues" :visit-values="visitValues" label="Left Ventricle" @add="onAdd" @new="onNew('echo-left-ventricle-value.php')"/>

    </div>


  </div>

</template>

<script>
import mixins from "./mixins";
import CommonView from "./CommonView";


export default {
  name      : "EchoLeftVentricleValues",
  components: { CommonView  },
  mixins    : [mixins],

  /* ### DATA ### */
  data() {
    return {
      allValues   : [],
      visitValues : [],
      selectedItem: -1,
      REPORT_TYPE : 'echo_left_ventricle_values'
    }
  }, /* DATA */

  /* ### COMPUTED ### */
  computed: {

    visit: function () {
      return this.$store.getters.getVisit;
    }

  }, /* COMPUTED */

  /* ### MOUNTED ### */
  mounted() {

    this.fetchAllValues()
    this.fetchVisitValues()

  }, /* MOUNTED */

  /* ### METHODS ### */
  methods: {

    fetchAllValues: function () {
      $.get(`${getSiteURL()}/api/get/echo/echo-left-ventricle-values.php`)
          .done(response => {
            this.allValues = response.data
          })
          .fail(error => {
            console.log(error)
          })
    }, /* fetch all values */


  }/* METHODS */
}
</script>

<style scoped>

</style>
