<template>
  <div class="card" id="form_add_disease">
    <div class="card-header">Add a disease</div>
    <div class="card-body">

      <div class="form-group">
        <label for="field_disease">Disease name <span class="badge badge-danger">required</span></label>
        <input type="text" id="field_disease" class="form-control" v-model="disease.disease" required>
        <div class="invalid-feedback">Disease name is required.</div>
      </div>

      <div class="form-group">
        <label for="field_disease_code">Disease code</label>
        <input type="text" id="field_disease_code" class="form-control" v-model="disease.disease_code">
      </div>

      <div class="form-group">
        <label for="field_description">Description</label>
        <RichEditor id="field_description" v-model="disease.description"></RichEditor>
      </div>

      <div class="text-right">
        <button class="btn btn-success" @click="addDisease" v-bind:class="{'disabled' : isEmptyDiseaseName}">Add disease</button>
      </div>

    </div>
  </div><!--card-->
</template>

<script>

import RichEditor from "../../_common/RichEditor";

export default {
  name: "AddDisease",
  components: {RichEditor},
  props: {},

  data() {
    return {
      disease: {
        disease: "",
        disease_code: "",
        description: "",
      }
    };
  },

  computed: {
    isEmptyDiseaseName() {
      return _.isEmpty(this.disease.disease);
    }
  },

  methods: {

    addDisease: function () {

      axios.post(`${getSiteUrl()}/api/disease/add`, {
        disease: this.disease.disease,
        disease_code: this.disease.disease_code,
        description: this.disease.description
      }).then(response => {

        showSuccessToast("Disease added");
        this.emitDiseaseAddedEvent();

      }).catch(error => {
        showErrorToast(error.response.data.message);
      });

    },

    emitDiseaseAddedEvent() {
      this.$emit("disease-added");
    }

  }
}
</script>

<style scoped>

</style>