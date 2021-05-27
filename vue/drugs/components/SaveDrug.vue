<template>

  <div class="card">
    <div class="card-header">Add a drug</div>
    <div class="card-body">

      <div class="">
        <div class="form-group">
          <label for="text-drug-name">Drug name</label>
          <input type="text" id="text-drug-name" class="form-control" v-model="drug.drug_name">
        </div>

        <div class="form-group">
          <label for="text-remarks">Remarks</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model="drug.remarks"></textarea>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" :disabled="!isFormValid" @click="onSave()">Save</button>
        </div>

      </div>

    </div>
  </div>

</template>

<script>
import {errorMessageBox} from "../../_common/bootbox_dialogs";

export default {
  name: "SaveDrug",

  data() {
    return {
      drug: {
        drug_name: "",
        remarks: "",
      }
    }
  },

  computed: {

    isFormValid() {
      return this.drug.drug_name !== "";
    }

  },

  mounted() {
    //
  },

  methods: {

    async onSave() {

      try {

        const params = {
          drug_name: this.drug.drug_name,
          remarks: this.drug.remarks,
        };

        await this.$store.dispatch("drugs_save", params);

        await this.$store.dispatch("drugs_fetchAll");

      } catch (e) {
        errorMessageBox("Failed to save");
      }

    },

  },

}
</script>

<style scoped>

</style>
