<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">Add a drug</div>
    <div class="card-body">

      <div class="">
        <div class="form-group">
          <label for="text-drug-name">Drug name</label>
          <input type="text" id="text-drug-name" class="form-control" v-model.trim="drug.drug_name">
        </div>

        <div class="form-group">
          <label for="text-remarks">Remarks</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model.trim="drug.remarks"></textarea>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" :disabled="!isFormValid" @click="onSave()">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Save
          </button>
        </div>

      </div>

    </div>
  </div>

</template>

<script>
import {errorMessageBox} from '../../_common/bootbox_dialogs';

export default {
  name: 'SaveDrug',

  data() {
    return {
      drug: {
        drug_name: '',
        remarks: '',
      },
    };
  },

  computed: {

    isFormValid() {
      return this.drug.drug_name !== '';
    },

  },

  mounted() {
    //
  },

  methods: {

    /*
    * On save
    * */
    async onSave() {

      try {

        const params = {
          drug_name: this.drug.drug_name,
          remarks: this.drug.remarks,
        };

        await this.$store.dispatch( 'drugs_save', params );

        this.drug.drug_name = '';

      } catch ( e ) {
        errorMessageBox( 'Failed to save' );
      }

      try {
        await this.$store.dispatch( 'drugs_fetchAll' );
      } catch ( e ) {
        errorMessageBox( 'Failed to fetch drugs details' );
      }

    },

  },

};
</script>

<style scoped>

</style>
