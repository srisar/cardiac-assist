<template>

  <div class="card">
    <div class="card-header">Edit {{ selectedDrug.drug_name }}</div>
    <div class="card-body">

      <div class="">
        <div class="form-group">
          <label for="text-drug-name">Drug name</label>
          <input type="text" id="text-drug-name" class="form-control" v-model="selectedDrug.drug_name">
        </div>

        <div class="form-group">
          <label for="text-remarks">Remarks</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model="selectedDrug.remarks"></textarea>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" @click="onUpdate()" :disabled="!isFormValid">Update</button>
        </div>

      </div>

    </div>
  </div>

</template>

<script>
import {errorMessageBox} from "../../_common/bootbox_dialogs";

const _ = require("lodash");

export default {
  name: "EditDrug",
  data() {
    return {}
  },

  computed: {
    selectedDrug() { return _.cloneDeep(this.$store.getters.getSelectedDrug) },

    isFormValid() {
      return this.selectedDrug.drug_name !== "";
    }

  },

  mounted() {
    //
  },

  methods: {

    async onUpdate() {

      try {

        const params = {
          id: this.selectedDrug.id,
          drug_name: this.selectedDrug.drug_name,
          remarks: this.selectedDrug.remarks,
        };

        await this.$store.dispatch("drugs_update", params);

        await this.$store.dispatch("drugs_fetchAll");

      } catch (e) {
        errorMessageBox("Failed to update drugs details");
      }

    }

  },
}
</script>

<style scoped>

</style>
