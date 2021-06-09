<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Add an investigation</div>
      <div class="card-body">

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Investigation name</label>
              <input type="text" class="form-control" v-model.trim="investigation.investigation_name">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row">
          <div class="col">
            <RichEditorV2 v-model="investigation.description"/>
          </div>
        </div>

        <div class="form-row my-2">
          <div class="col text-center">
            <button class="btn btn-success" @click="onSave()" :disabled="!isValidForm">Save</button>
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
  name: "SaveInvestigation",
  components: {RichEditorV2,},


  data() {
    return {

      investigation: {
        investigation_name: "",
        description: "",
      },
    }
  },

  computed: {
    isValidForm: function () {
      return this.investigation.investigation_name !== "";

    }
  },

  mounted() {
    //
  },

  methods: {
    //

    async onSave() {

      try {

        const params = {
          investigation_name: this.investigation.investigation_name,
          description: this.investigation.description,
        };


        await this.$store.dispatch("investigations_add", params);
        await this.$store.dispatch("investigations_fetchAll");


      } catch (e) {
        errorMessageBox("Failed to add the investigation");
      }

    },

  },

}
</script>

<style scoped>

</style>
