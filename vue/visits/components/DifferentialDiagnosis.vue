<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Differential Diagnosis

        <div class="float-right">
          <button class="btn btn-tiny btn-success" @click="onOpenAddDiffDiagModal">Add</button>
        </div>

      </div>

      <div class="card-body">


        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 50px">Code</th>
            <th style="width: 200px">Disease</th>
            <th>Remarks</th>
            <th style="width: 50px" class="text-center"></th>
            <th style="width: 100px" class="text-center"></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in diffDiagnosisList">
            <td>{{ item.disease.disease_code }}</td>
            <td>{{ item.disease.disease }}</td>
            <td>{{ item.remarks }}</td>
            <td class="text-center"><a :href="createDiseaseLink(item.disease)" target="_blank" class="btn btn-tiny btn-secondary">View</a></td>
            <td class="text-center">
              <button class="btn btn-tiny btn-primary" @click="onOpenEditDiffDiagModal(item)">Edit</button>
              <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Delete</button>
            </td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->

    </div><!-- card -->


    <!-- Modal Add Diff Diagnosis -->
    <ModalWindow id="modal-add-diff-diagnosis" :visible="addModalVisible" @close="onCloseAddDiffDiagModal">
      <template v-slot:title>Add a differential diagnosis</template>
      <slot>

        <div class="form-row">

          <div class="col">

            <div class="form-group">
              <label>Disease</label>
              <select class="form-control" v-model="diffDiagnosisToAdd.disease">
                <option value="-1" disabled>SELECT</option>
                <option v-for="item in diseasesList" :value="item">{{ item.disease }}</option>
              </select>
            </div>

          </div><!-- col -->

        </div><!-- row -->


        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="diffDiagnosisToAdd.remarks"></textarea>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="form-row">
          <div class="col text-center">

            <button class="btn btn-success" @click="onAdd">Add</button>

          </div>
        </div>

      </slot>
    </ModalWindow><!-- Modal Add Diff Diagnosis -->


    <!-- Modal Edit Diff Diagnosis -->
    <ModalWindow id="modal-edit-diff-diagnosis" @close="onCloseEditDiffDiagModal" :visible="editModalVisible">
      <template v-slot:title v-if="diffDiagnosisToEdit">Edit {{ diffDiagnosisToEdit.disease.disease }}</template>
      <slot v-if="diffDiagnosisToEdit">

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Disease</label>
              <input class="form-control" type="text" readonly :value="diffDiagnosisToEdit.disease.disease">
            </div>

            <div class="w-100"></div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" rows="5" v-model="diffDiagnosisToEdit.remarks"></textarea>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onUpdate">Update</button>
          </div>
        </div>

      </slot>
    </ModalWindow><!-- Modal Edit Diff Diagnosis -->

  </div><!-- Template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";

const _ = require('lodash');

export default {
  name: "DifferentialDiagnosis",
  components: {ModalWindow},

  /*
  * --------------------------------------------------------------
  * DATA
  * */
  data() {
    return {
      addModalVisible: false,
      editModalVisible: false,

      diffDiagnosisToAdd: {
        disease: "-1",
        remarks: "",
      },

      diffDiagnosisToEdit: null,

    }
  },

  /*
  * --------------------------------------------------------------
  * COMPUTED
  * */
  computed: {
    diffDiagnosisList: function () {
      return this.$store.getters.differentialDiagnosisList;
    },

    diseasesList: function () {
      return this.$store.getters.diseasesList;
    }

  },

  /*
  * --------------------------------------------------------------
  * MOUNTED
  * */
  mounted() {
    this.$store.dispatch('fetchDiseases');
  },

  /*
  * --------------------------------------------------------------
  * METHODS
  * */
  methods: {

    createDiseaseLink: function (disease) {
      return `${getSiteURL()}/app/diseases/view.php?id=${disease.id}`;
    },


    /*
   * Add selected disease to diff. diagnosis
   * */
    onAdd: function () {

      // check if selected symptom is already added
      const s = _.find(this.diffDiagnosisList, (o) => {
        return o.disease.id === this.diffDiagnosisToAdd.disease.id;
      });

      if (s !== undefined) {
        alert(`${this.diffDiagnosisToAdd.disease.disease} is already added`);
      } else {

        this.$store.dispatch('addDifferentialDiagnosis', this.diffDiagnosisToAdd)
            .catch(e => {
              console.log("Failed to add diff. diagnosis");
              console.log(e);
            });
      }

    },


    onUpdate: function () {

      this.$store.dispatch('updateDiffDiagnosis', this.diffDiagnosisToEdit)
          .then(r => {
            this.editModalVisible = false;
          })
          .catch(e => {
            alert("Failed to update differential diagnosis");
            console.log(e);
          })

    },

    onDelete: function (diffDiagnosis) {

      this.$store.dispatch('deleteDiffDiagnosis', diffDiagnosis);

    },

    onOpenAddDiffDiagModal: function () {
      this.addModalVisible = true;
    },

    onCloseAddDiffDiagModal: function () {
      this.addModalVisible = false;
    },


    onOpenEditDiffDiagModal: function (diffDiagnosis) {
      this.diffDiagnosisToEdit = diffDiagnosis;
      this.editModalVisible = true;
    },

    onCloseEditDiffDiagModal: function () {
      this.editModalVisible = false;
    },

  },

}
</script>

<style scoped>

</style>
