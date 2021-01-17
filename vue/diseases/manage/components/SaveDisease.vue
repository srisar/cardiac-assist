<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Add a disease</div>
      <div class="card-body">

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Disease</label>
              <input type="text" class="form-control" v-model.trim="disease.disease">
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
            <RichEditor ref="richEditor" @input="getDescription"/>
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

export default {
  name: "SaveDisease",
  components: {RichEditor,},

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

    onClickSave: function () {

      this.$store.dispatch('saveDisease', this.disease)
          .then(r => {
            alert('Saved.');
          })
          .catch(e => {
            alert(e.responseJSON.message);
          });

    },

    getDescription: function (data) {
      this.disease.description = data;
    }

  },

}
</script>

<style scoped>

</style>
