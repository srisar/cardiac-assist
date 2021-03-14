<template>

  <div>

    <div class="form-row">

      <div class="col">

        <table class="table table-bordered table-sm">
          <tr>
            <td class="font-weight-bold">TC</td>
            <td class="font-weight-bold">LDL</td>
            <td class="font-weight-bold">HDL</td>
            <td class="font-weight-bold">TG</td>
            <td class="font-weight-bold">NHC</td>
          </tr>
          <tr>
            <td><input type="text" class="form-control" v-model="visitLipids.tc"></td>
            <td><input type="text" class="form-control" v-model="visitLipids.ldl"></td>
            <td><input type="text" class="form-control" v-model="visitLipids.hdl"></td>
            <td><input type="text" class="form-control" v-model="visitLipids.tg"></td>
            <td><input type="text" class="form-control" v-model="visitLipids.nhc"></td>
          </tr>
        </table>

      </div>
    </div><!-- row -->

    <div class="form-row">
      <div class="col text-center">
        <button class="btn btn-success" @click="onUpdate">Update</button>
      </div>
    </div>


  </div><!-- template -->

</template>

<script>
export default {
  name: "VisitLipids",

  data() {
    return {
      exist: false,

      visitLipids: {
        id      : undefined,
        visit_id: undefined,
        tc      : 0,
        ldl     : 0,
        hdl     : 0,
        tg      : 0,
        nhc     : 0
      },

    }
  },

  computed: {

    visit: function () { return this.$store.getters.getVisit; },

  },

  mounted() {

    this._fetch()

  },


  methods: {

    onUpdate: function () {
      const params = {
        id : this.visitLipids.id,
        tc : this.visitLipids.tc,
        ldl: this.visitLipids.ldl,
        hdl: this.visitLipids.hdl,
        tg : this.visitLipids.tg,
        nhc: this.visitLipids.nhc,
      };

      $.post(`${getSiteURL()}/api/update/visit/visit-lipids.php`, params)
          .done(r => {
            bootbox.alert("Lipid details updated");
          })
          .fail(e => {
            bootbox.alert("Failed to update lipid details");
          });
    }, /* update */


    _fetch: function () {

      const params = { visit_id: this.visit.id, };

      $.get(`${getSiteURL()}/api/get/visit/visit-lipids.php`, params)
          .done(response => {
            this.visitLipids = response.data
          })
          .fail(error => {
            console.log(error)
          });

    }, /* fetch from database */


  },
}
</script>

<style scoped>

</style>
