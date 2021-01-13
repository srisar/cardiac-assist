<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        <div class="float-left">
          <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ editButtonText }}</button>
        </div>
        <div>{{ symptom.symptom_name }}</div>
      </div>
      <div class="card-body">


        <div v-if="editable" class="edit-form">
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
              <RichEditor :data="symptom.description" @input="getSymptomDescription"/>
            </div>
          </div>

          <div class="form-row my-2">
            <div class="col text-center">
              <button class="btn btn-success" @click="onClickUpdate">Update</button>
            </div>
          </div>
        </div><!-- edit-form -->


        <div v-else class="view-form">
          <RichViewer :data="symptom.description"/>
        </div><!-- view-form -->

      </div>
    </div><!-- card -->

  </div>

</template>

<script>

import RichViewer from "../../_common/components/RichViewer";
import RichEditor from "../../_common/components/RichEditor";
import Vue from "vue";

export default {
  name: "EditSymptom",
  components: {RichEditor, RichViewer},
  props: [],


  data() {
    return {
      editable: false,
      symptomDescription: this.$store.getters.getSelectedSymptom.description,

    }
  },

  computed: {

    symptom: function () {
      this.editable = false;
      return this.$store.getters.getSelectedSymptom;
    },

    editButtonText: function () {
      return this.$store.getters.getEditButtonText;
    }

  },

  watch: {},


  methods: {
    //

    onClickUpdate: function () {

      $.post(`${getSiteURL()}/api/update/symptom.php`, {
        id: this.symptom.id,
        symptom_name: this.symptom.symptom_name,
        description: this.symptomDescription,
      }).done(r => {

        alert(this.symptom.symptom_name + ' updated');
        this.$store.dispatch('fetchSymptoms');

      }).fail(e => {

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

    getSymptomDescription: function (data) {
      this.symptomDescription = data;
    }

  },


}
</script>

<style scoped>

</style>
