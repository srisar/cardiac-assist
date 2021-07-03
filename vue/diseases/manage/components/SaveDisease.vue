<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Add a disease</div>
      <div class="card-body">

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Disease</label>
              <input type="text" class="form-control" :class="{'is-invalid': !isValidForm, 'is-valid': isValidForm}" v-model.trim="disease.disease">
              <div class="invalid-feedback">Required.</div>
              <div class="valid-feedback">All looks good!</div>
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Disease code</label>
              <input type="text" class="form-control" v-model.trim="disease.disease_code">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row">
          <div class="col">
            <RichEditorV2 v-model="disease.description"/>
          </div>
        </div>

        <div class="form-row my-2">
          <div class="col text-center">
            <button class="btn btn-success" @click="onSave()" :disabled="!isValidForm">
              <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Save
            </button>
          </div>
        </div>
      </div>
    </div><!-- card -->


  </div><!-- template -->

</template>

<script>

import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "SaveDisease",
  components: { RichEditorV2, },

  props: [],

  data() {
    return {

      disease: {
        disease: "",
        disease_code: "",
        description: "",
      },
    }
  },

  computed: {
    isValidForm: function () {
      return this.disease.disease !== "";

    }
  },

  mounted() {
    //
  },

  methods: {
    //

    /*
    * On save disease
    * */
    async onSave() {

      try {

        const params = {
          disease: this.disease.disease,
          disease_code: this.disease.disease_code,
          description: this.disease.description,
        };

        await this.$store.dispatch( "diseases_add", params );
        await this.$store.dispatch( "diseases_fetchAll" );

      } catch ( e ) {
        errorMessageBox( "Failed to save new disease" );
      }


    },

  },

}
</script>

<style scoped>

</style>
