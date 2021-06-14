<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header"> Lipids</div>

      <div class="card-body">

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
            <button class="btn btn-success" @click="onUpdate()">Update</button>
          </div>
        </div>


      </div>
    </div><!-- card -->

  </div><!-- template -->

</template>

<script>
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "VisitLipidsView",

  data() {
    return {
      exist: false,

      visitLipids: {
        id: undefined,
        visit_id: undefined,
        tc: 0,
        ldl: 0,
        hdl: 0,
        tg: 0,
        nhc: 0
      },

    }
  },

  computed: {

    visit: function () {
      return this.$store.getters.getVisit;
    },

    visitId: function () {
      return this.$store.getters.getVisitId
    },

  },

  async mounted() {

    try {

      const params = {
        visit_id: this.visitId,
      }

      const response = await $.get(`${getSiteURL()}/api/get/visit/visit-lipids.php`, params);
      this.visitLipids = response.data;

    } catch (e) {
      errorMessageBox("Failed to fetch lipids details");
    }

  },

  methods: {

    async onUpdate() {

      try {

        const params = {
          id: this.visitLipids.id,
          tc: this.visitLipids.tc,
          ldl: this.visitLipids.ldl,
          hdl: this.visitLipids.hdl,
          tg: this.visitLipids.tg,
          nhc: this.visitLipids.nhc,
        };

        await $.post(`${getSiteURL()}/api/update/visit/visit-lipids.php`, params);

        successMessageBox("Lipid details updated");

      } catch (e) {
        errorMessageBox("Failed to update lipids details");
      }
    }, /* update */


  },

}
</script>

<style scoped>

</style>
