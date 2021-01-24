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
            <button class="btn btn-success" @click="onClickSave" :disabled="!isValidForm">Save</button>
          </div>
        </div>
      </div>
    </div><!-- card -->


  </div><!-- template -->

</template>

<script>

import RichEditor from "../../../_common/components/RichEditor";
import RichEditorV2 from "../../../_common/components/RichEditorV2";

export default {
  name: "SaveSymptom",
  components: {RichEditor, RichEditorV2},

  props: [],

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

    onClickSave: function () {

      this.$store.dispatch('saveSymptom', this.symptom)
          .then(r => {
            alert('Saved.');
          })
          .catch(e => {
            alert(e.responseJSON.message);
          });

    },

  },

}
</script>

<style scoped>

</style>
