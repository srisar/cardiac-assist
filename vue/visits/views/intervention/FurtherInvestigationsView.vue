<template>

  <div>

    <div class="row">
      <div class="col">
        <h3 class="text-center">Interventions</h3>
      </div>
    </div>


    <div class="row">
      <div class="col">

        <div class="card shadow shadow-sm mb-3">
          <div class="card-header">Add an investigation</div>
          <div class="card-body">

            <div class="form-group">
              <label>Investigation</label>
              <select class="custom-select" v-model.number="investigationToAdd.investigation_id" :class="{'is-invalid': isAddFormInvalid}">
                <option value="-1" disabled selected>SELECT ONE</option>
                <option v-for="item in investigationsList" :value="item.id">{{ item.investigation_name }}</option>
              </select>
            </div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="3" class="form-control" v-model="investigationToAdd.remarks" placeholder="Add useful remarks for the investigation..."></textarea>
            </div>

            <div class="text-center">
              <button class="btn btn-success" :disabled="isAddFormInvalid" @click="onAdd()">Add</button>
            </div>

          </div>
        </div><!-- card -->


        <div class="card shadow shadow-sm">

          <div class="card-header">Further Investigations</div>

          <div class="card-body">

            <table class="table table-sm table-bordered">
              <tbody>
              <tr v-for="item in furtherInvestigationsList" :key="item.id">
                <td>
                  <p class="font-weight-bold">{{ item.investigation.investigation_name }}</p>
                  <div>{{ item.remarks }}</div>

                  <div class="my-2 d-flex justify-content-between">
                    <button class="btn btn-tiny btn-primary">Edit</button>
                    <button class="btn btn-tiny btn-danger">Remove</button>
                  </div>

                </td>
              </tr>
              </tbody>

            </table>

          </div>

        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->


  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "FurtherInvestigationsView",

  data() {
    return {

      /* all investigations the db */
      investigationsList: [],

      /* added further investigations */
      furtherInvestigationsList: [],

      investigationToAdd: {
        investigation_id: -1,
        remarks: ""
      }
    }
  },


  computed: {

    visitId() {
      return this.$store.getters.getVisitId;
    },

    isAddFormInvalid() {
      return this.investigationToAdd.investigation_id === -1;
    },

  },

  async mounted() {

    try {

      /* 1.fetch all investigations */
      this.$store.dispatch("fetchInvestigations").then(() => {
        this.investigationsList = this.$store.getters.getInvestigationsList;
      });


      /* 2. fetch all further investigations */
      await this.$store.dispatch("furtherInvestigations_fetchAll", this.visitId);
      this.furtherInvestigationsList = this.$store.getters.getFurtherInvestigationsList;


    } catch (e) {
      errorMessageBox("Failed to load data");
    }

  },

  methods: {

    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          investigation_id: this.investigationToAdd.investigation_id,
          remarks: this.investigationToAdd.remarks
        };

        await this.$store.dispatch("furtherInvestigations_add", params);

        /* fetch added  further investigations */
        await this.$store.dispatch("furtherInvestigations_fetchAll", this.visitId);
        this.furtherInvestigationsList = this.$store.getters.getFurtherInvestigationsList;

      } catch (e) {
        errorMessageBox("Failed to add the investigation");
      }

    }


  },

}
</script>

<style scoped>

</style>
