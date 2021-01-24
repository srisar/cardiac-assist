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
            <button class="btn btn-success" @click="onClickSave" :disabled="!isValidForm">Save</button>
          </div>
        </div>
      </div>
    </div><!-- card -->


  </div><!-- template -->

</template>

<script>

import RichEditorV2 from "../../../_common/components/RichEditorV2";


export default {
  name: "SaveInvestigation",
  components: {RichEditorV2,},

  props: [],

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

    onClickSave: function () {

      this.$store.dispatch('saveInvestigation', this.investigation)
          .then(r => {
            alert('Saved.');

            //clear form fields
            this.investigation = {
              investigation_name: "",
              description: "",
            }

          })
          .catch(e => {
            alert(e.responseJSON.message);
          });

    },

    getDescription: function (data) {
      this.investigation.description = data;
    }

  },

}
</script>

<style scoped>

</style>
