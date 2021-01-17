<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        <div class="float-left">
          <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ editButtonText }}</button>
        </div>
        <div>{{ disease.disease }}</div>
      </div>
      <div class="card-body">


        <div v-if="editable" class="edit-form">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Disease name</label>
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
              <RichEditor :data="disease.description" @input="getDescription"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onClickUpdate">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichViewer :data="disease.description"/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichViewer from "../../../_common/components/RichViewer";
import RichEditor from "../../../_common/components/RichEditor";
import Vue from "vue";

export default {
  name: "EditDisease",
  components: {RichEditor, RichViewer},
  props: [],


  data() {
    return {
      editable: false,
      description: this.$store.getters.getSelectedDisease.description,

    }
  },

  computed: {

    disease: function () {
      this.editable = false;
      return this.$store.getters.getSelectedDisease;
    },

    editButtonText: function () {
      return this.$store.getters.getEditButtonText;
    },

  },

  watch: {},


  methods: {

    onClickUpdate: function () {
      this.disease.description = this.description;

      this.$store.dispatch('updateDisease', this.disease)
          .then(r => {
            alert('Symptom updated');
          })
          .catch(e => {
            alert('Update failed');
          });

    },

    onClickEdit: function () {
      if (this.editable) {
        this.editable = false;
        this.$store.commit('setEditButtonText', 'Edit');
      } else {
        this.editable = true;
        this.$store.commit('setEditButtonText', 'View');
      }
    },

    getDescription: function (data) {
      this.description = data;
    }

  },


}
</script>

<style scoped>

</style>
