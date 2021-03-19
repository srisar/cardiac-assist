<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Diagnoses</div>
        <div>
          <button class="btn btn-tiny btn-success" @click="onOpenAddModal">Add</button>
        </div>
      </div><!-- card-header -->

      <div class="card-body">


        <table class="table table-sm table-bordered" v-if="!isEmpty">
          <thead>
          <tr>
            <th style="width: 50px">Code</th>
            <th style="width: 200px">Disease</th>
            <th>Remarks</th>
            <th style="width: 30px" class="text-center"></th>
            <th style="width: 60px" class="text-center"></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in visitDiagnosisList">
            <td>{{ item.disease.disease_code }}</td>
            <td>{{ item.disease.disease }}</td>
            <td>
              <pre>{{ item.remarks }}</pre>
            </td>
            <td class="text-center"><a :href="createDiseaseLink(item.disease)" target="_blank"
                                       class="btn btn-tiny btn-secondary"><i class="bi bi-bookmark-star-fill"></i></a>
            </td>
            <td class="text-center">
              <button class="btn btn-tiny btn-primary" @click="onOpenEditModal(item)"><i
                  class="bi bi-pencil"></i></button>
              <button class="btn btn-tiny btn-danger" @click="onDelete(item)"><i class="bi bi-trash-fill"></i></button>
            </td>
          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding some diagnoses</p>
        </div>

      </div><!-- card-body -->

    </div><!-- card -->


    <!-- Modal Add Diff Diagnosis -->
    <ModalWindow id="modal-add-diff-diagnosis" :visible="addModalVisible" @close="onCloseAddModal">
      <template v-slot:title>Add a differential diagnosis</template>
      <slot>

        <div class="form-row">

          <div class="col">

            <div class="form-group">
              <label>Disease</label>
              <select class="form-control" v-model="visitDiagnosisToAdd.disease">
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
              <textarea rows="5" class="form-control" v-model="visitDiagnosisToAdd.remarks"></textarea>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="form-row">
          <div class="col text-center">

            <button class="btn btn-success" @click="onAdd">Add</button>

          </div>
        </div>

      </slot>
    </ModalWindow><!-- Modal Add Visit Diagnosis -->


    <!-- Modal Edit Visit Diagnosis -->
    <ModalWindow id="modal-edit-diff-diagnosis" @close="onCloseEditModal" :visible="editModalVisible">
      <template v-slot:title v-if="visitDiagnosisToEdit">Edit {{ visitDiagnosisToEdit.disease.disease }}</template>
      <slot v-if="visitDiagnosisToEdit">

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Disease</label>
              <input class="form-control" type="text" readonly :value="visitDiagnosisToEdit.disease.disease">
            </div>

            <div class="w-100"></div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" rows="5" v-model="visitDiagnosisToEdit.remarks"></textarea>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onUpdate">Update</button>
          </div>
        </div>

      </slot>
    </ModalWindow><!-- Modal Edit Visit Diagnosis -->

  </div><!-- Template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";

const _ = require('lodash');

export default {
  name: "VisitDiagnosis",
  components: {ModalWindow},

  data() {
    return {
      addModalVisible: false,
      editModalVisible: false,

      visitDiagnosisToAdd: {
        disease: "-1",
        remarks: "",
      },

      visitDiagnosisToEdit: null,
    }
  },
  /* *** DATA *** */


  computed: {
    visitDiagnosisList: function () {
      return this.$store.getters.getVisitDiagnosisList;
    },

    diseasesList: function () {
      return this.$store.getters.diseasesList;
    },

    isEmpty: function () {
      return this.visitDiagnosisList.length === 0;
    },

  },
  /* *** COMPUTED *** */


  mounted() {
    this.$store.dispatch('fetchDiseases');
  },
  /* *** MOUNTED *** */


  methods: {

    createDiseaseLink: function (disease) {
      return `${getSiteURL()}/app/diseases/view.php?id=${disease.id}`;
    },


    /*
   * Add selected disease to diff. diagnosis
   * */
    onAdd: function () {

      // check if selected symptom is already added
      const s = _.find(this.visitDiagnosisList, (o) => {
        return o.disease.id === this.visitDiagnosisToAdd.disease.id;
      });

      if (s !== undefined) {
        alert(`${this.visitDiagnosisToAdd.disease.disease} is already added`);
      } else {

        this.$store.dispatch('addVisitDiagnosis', this.visitDiagnosisToAdd)
            .catch(e => {
              console.log("Failed to add diagnosis");
              console.log(e);
            });
      }

    },


    onUpdate: function () {

      this.$store.dispatch('updateVisitDiagnosis', this.visitDiagnosisToEdit)
          .then(() => {
            this.editModalVisible = false;
          })
          .catch(e => {
            alert("Failed to update diagnosis");
            console.log(e);
          })

    },

    onDelete: function (diagnosis) {

      this.$store.dispatch('deleteVisitDiagnosis', diagnosis);

    },

    onOpenAddModal: function () {
      this.addModalVisible = true;
    },

    onCloseAddModal: function () {
      this.addModalVisible = false;
    },


    onOpenEditModal: function (diagnosis) {
      this.visitDiagnosisToEdit = diagnosis;
      this.editModalVisible = true;
    },

    onCloseEditModal: function () {
      this.editModalVisible = false;
    },

  },

}
</script>

<style scoped>

</style>
