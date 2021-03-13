<template>

  <div class="report-section" @mouseover="inputVisible = true" @mouseleave="inputVisible = false">

    <div class="alert alert-dark shadow shadow-sm p-2">

      <div class="report-section__title text-uppercase mb-2 d-flex justify-content-between">

        <div>Right Atrium</div>

        <div>
          <div class="btn-group dropleft">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
              Remarks
            </button>
            <div class="dropdown-menu" style="width: 800px">
              <button style="white-space: initial;" class="dropdown-item" type="button" v-for="item in allValues" @click="onAdd(item)">{{ item.value }}</button>
            </div>
          </div>

          <button class="btn btn-primary btn-sm" type="button" @click="onNew('echo-right-atrium-value.php')"><i class="bi bi-plus-circle"></i></button>

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
import mixins from "./mixins";

export default {
  name  : "EchoRightAtriumValues",
  mixins: [mixins],

  /* ### DATA ### */
  data() {
    return {
      allValues   : [],
      visitValues : [],
      selectedItem: -1,

      REPORT_TYPE: 'echo_right_atrium_values'
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
      $.get(`${getSiteURL()}/api/get/echo-right-atrium-values.php`)
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
