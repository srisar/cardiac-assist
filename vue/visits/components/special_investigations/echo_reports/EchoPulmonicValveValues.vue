<template>

  <div class="report-section">

    <div class="alert alert-dark shadow shadow-sm p-2">

      <div class="report-section__title text-uppercase">Pulmonic Valve</div>
      <div class="input-group mb-3">
        <select class="form-control" v-model="selectedItem">
          <option value="-1" disabled>SELECT</option>
          <option v-for="item in allValues" :value="item">{{ item.value }}</option>
        </select>
        <div class="input-group-append">
          <button class="btn btn-success" type="button" @click="onAdd">Add</button>
        </div>
      </div>

      <table class="table table-sm table-bordered">
        <tr v-for="item in visitValues">
          <td>{{ item.value }}</td>
          <td class="text-center" style="width: 50px">
            <button class="btn btn-tiny btn-danger" @click="onRemove(item)">Remove</button>
          </td>
        </tr>
      </table>

    </div>


  </div>

</template>

<script>

const REPORT_TYPE = 'echo_pulmonic_valve_values'

export default {
  name: "EchoPulmonicValveValues",

  /* ### DATA ### */
  data() {
    return {
      allValues   : [],
      visitValues : [],
      selectedItem: -1,
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
      $.get(`${getSiteURL()}/api/get/echo-pulmonic-valve-values.php`)
          .done(response => {
            this.allValues = response.data
          })
          .fail(error => {
            console.log(error)
          })
    }, /* fetch all values */

    fetchVisitValues: function () {
      const params = {
        visit_id   : this.visit.id,
        report_type: REPORT_TYPE
      }

      $.get(`${getSiteURL()}/api/get/visit-echo-report-values.php`, params)
          .done(response => {
            this.visitValues = response.data
          })
          .fail(error => {

          })
    }, /* fetch visit values */

    onRemove: function (item) {

      const params = {
        visit_id   : item.visit_id,
        value_id   : item.id,
        report_type: REPORT_TYPE
      }

      $.get(`${getSiteURL()}/api/delete/visit-echo-report-value.php`, params)
          .done(response => {
            this.fetchVisitValues()
          })
          .fail(error => {
            bootbox.alert('<p class="lead">Failed to remove</p>')
          })
    }, /* on remove */

    onAdd: function () {

      const params = {
        visit_id   : this.visit.id,
        value_id   : this.selectedItem.id,
        report_type: REPORT_TYPE
      }

      $.get(`${getSiteURL()}/api/save/visit-echo-report-value.php`, params)
          .done(response => {
            this.fetchVisitValues()
            this.selectedItem = -1
          })
          .fail(error => {
            bootbox.alert('<p class="lead">Failed to add</p><p>Please select a valid option</p>')
          })

    },


  }, /* METHODS */

}
</script>

<style scoped>

</style>
