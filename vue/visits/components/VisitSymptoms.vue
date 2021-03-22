<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Clinical Details (Symptoms)</div>
        <div>
          <button class="btn btn-tiny btn-success" @click="onShowAddModal">Add</button>
        </div>

      </div><!-- card-header -->

      <div class="card-body">


        <table class="table table-sm table-bordered" v-if="!isEmpty">
          <thead>
          <tr>
            <th>Symptom</th>
            <th style="width: 50px" class="text-center">Duration</th>
            <th style="width: 30px" class="text-center"></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in visitSymptomsList">
            <td><a :href="createSymptomLink(item.symptom)" target="_blank">{{ item.symptom.symptom_name }}</a></td>
            <td class="text-center">{{ item.duration }}</td>
            <td class="text-center">
              <button class="btn btn-tiny btn-danger" @click="onClickDelete(item)"><i class="bi bi-trash-fill"></i>
              </button>
            </td>
          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding some symptoms.</p>
        </div>

      </div><!-- card-body -->

    </div><!-- card -->


    <ModalWindow id="modal-add-visit-symptom" :visible="modalAddVisitSymptomVisible" @close="onCloseAddModal">
      <template v-slot:title>Add a symptom to clinical details</template>
      <slot>

        <!-- section : add symptom -->
        <div class="row text-center justify-content-center">
          <div class="col">

            <div class="form-group">
              <label>Symptom</label>
              <select class="custom-select" v-model="selectedSymptom">
                <option value="-1" disabled>SELECT</option>
                <option v-for="item in symptomsList" :value="item">{{ item.symptom_name }}</option>
              </select>
            </div>

          </div><!-- col -->

          <div class="w-100"></div>

          <div class="col-2">
            <div class="form-group">
              <label>Duration</label>
              <input type="text" class="form-control" v-model="symptomDuration">
            </div>
          </div>

        </div><!-- row -->

        <div class="form-row text-center">
          <div class="col">
            <button class="btn btn-success" @click="onClickAdd">Add</button>
          </div>
        </div>


        <div class="row">

        </div><!-- row -->

        <!-- section: add symptom -->

      </slot>
    </ModalWindow>


  </div><!-- Template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";

const _ = require('lodash');

export default {
  name: "VisitSymptoms",
  components: {ModalWindow},

  /*
  *
  * DATA
  * */
  data() {
    return {
      modalAddVisitSymptomVisible: false,

      selectedSymptom: "-1",

      /* symptom duration*/
      symptomDuration: "1/",

    }
  },

  /*
  *
  * COMPUTED
  * */
  computed: {
    visitSymptomsList: function () {
      return this.$store.getters.getVisitSymptomsList;
    },

    symptomsList: function () {
      return this.$store.getters.getSymptomsList;
    },

    isEmpty: function () {
      return this.visitSymptomsList.length === 0;
    },

  },


  /*
  *
  * MOUNTED
  * */
  mounted() {
    this.$store.dispatch('fetchSymptoms');
  },


  /*
  *
  * METHODS
  * */
  methods: {

    createSymptomLink: function (symptom) {
      return `${getSiteURL()}/app/symptoms/view.php?id=${symptom.id}`;
    },


    /*
   * Add selected symptom to the visit
   * */
    onClickAdd: function () {

      // check if selected symptom is already added
      const s = _.find(this.visitSymptomsList, (o) => {
        return o.symptom.id === this.selectedSymptom.id;
      });

      if (s !== undefined) {
        alert(`${this.selectedSymptom.symptom_name} is already added`);
      } else {

        const payload = {
          symptom: this.selectedSymptom,
          duration: this.symptomDuration
        }

        this.$store.dispatch('addVisitSymptom', payload);
      }

    },

    onClickDelete: function (visitSymptom) {

      this.$store.dispatch('deleteVisitSymptom', visitSymptom);

    },


    /*
     *
     * Modal event handler
     * */
    onShowAddModal: function () {
      this.modalAddVisitSymptomVisible = true;
    },

    onCloseAddModal: function () {
      this.modalAddVisitSymptomVisible = false;
    }

  },

}
</script>

<style scoped>

</style>
