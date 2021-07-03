<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Add a symptom</div>
      <div class="card-body">

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Symptom name</label>
              <input type="text" class="form-control" v-model.trim="symptom.symptom_name">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row">
          <div class="col">
            <RichEditorV2 v-model="symptom.description"/>
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
  name: "SaveSymptom",
  components: {RichEditorV2},

  data() {
    return {

      symptom: {
        symptom_name: "",
        description: "",
      },
    }
  },

  computed: {
    isValidForm: function () {
      return this.symptom.symptom_name !== "";

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
          symptom_name: this.symptom.symptom_name,
          description: this.symptom.description,
        };

        await this.$store.dispatch("symptoms_add", params);
        await this.$store.dispatch("symptoms_fetchAll");

      } catch (e) {
        errorMessageBox("Failed to add the symptom");
      }

    },

  },

}
</script>

<style scoped>

</style>
