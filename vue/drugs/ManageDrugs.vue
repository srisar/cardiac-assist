<template>

  <div>

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-md-4">
          <!-- list drugs -->

          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <div>Drugs</div>
              <div>
                <button class="btn btn-tiny btn-success" @click="onAddNewDrug()">Add a drug</button>
              </div>
            </div>

            <div class="card-body">

              <table class="table table-sm table-bordered table-striped">
                <thead>
                <tr>
                  <th>Drug</th>
                  <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="drug in drugsList" :key="drug.id">
                  <td class="text-left">
                    <a class="btn-link" @click="onSelectDrug(drug)">{{ drug.drug_name }}</a>
                  </td>
                  <td>{{ drug.remarks }}</td>
                </tr>
                </tbody>
              </table>

            </div>

          </div>

        </div>


        <div class="col-12 col-md-8">
          <EditDrug v-if="panelMode === 'EDIT'"/>
          <SaveDrug v-if="panelMode === 'ADD'"/>
        </div>

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>
import EditDrug from "./components/EditDrug";
import SaveDrug from "./components/SaveDrug";

export default {
  name: "ManageDrugs",
  components: {SaveDrug, EditDrug},
  data() {
    return {}
  },

  computed: {

    drugsList() { return this.$store.getters.getDrugs; },

    panelMode() { return this.$store.getters.getPanelMode; },

  },

  async mounted() {

    try {

      await this.$store.dispatch("drugs_fetchAll");

    } catch (e) {
      console.log(e);
    }

  },

  methods: {

    onSelectDrug(drug) {
      this.$store.commit("setSelectedDrug", drug);
      this.$store.commit("setPanelModeEdit");
    },

    onAddNewDrug() {
      this.$store.commit("setPanelModeAdd");
    }


  },

}
</script>

<style scoped>

</style>
