<template>

  <div>

    <div class="card">
      <div class="card-header">

        <div class="float-left">
          <button class="btn btn-tiny btn-primary" @click="onClickShowAddVisitModal">Add a visit</button>
        </div>

        <div class="">
          Visits
        </div>

      </div>
      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 100px">Date</th>
            <th>Remarks</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in visitsList">
            <td><a :href="createVisitLink(item)">{{ item.visit_date }}</a></td>
            <td>{{ item.remarks }}</td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->
    </div><!-- card -->

    <ModalWindow id="modal-add-visit" :visible="modalAddVisit.visible" @modal-hiding="onHidingAddVisitModal">
      <template v-slot:title>Add a visit for {{ fullName }}</template>
      <slot>

        <div class="form-row">
          <div class="col-auto">
            <div class="form-group">
              <label>Date</label>
              <DateField v-model="visitToAdd.visit_date"/>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col">
            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" v-model="visitToAdd.remarks"></textarea>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onClickSave">Save</button>
          </div>
        </div>

      </slot>
    </ModalWindow>

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../../_common/components/ModalWindow";
import DateField from "../../../_common/components/DateField";

export default {
  name: "ListVisits",
  components: {ModalWindow, DateField},
  data() {
    return {

      modalAddVisit: {
        visible: false,
      },

      visitToAdd: {
        patient_id: undefined,
        visit_date: moment().format('YYYY-MM-DD'),
        remarks: "",
      }

    }
  },

  computed: {

    visitsList: function () {
      return this.$store.getters.getVisitsList;
    },

    patient: function () {
      return this.$store.getters.getPatient;
    },

    fullName: function () {
      return this.patient.first_name + " " + this.patient.last_name;
    },

  },

  mounted() {

  },

  methods: {


    createVisitLink: function (visit) {
      return `${getSiteURL()}/app/visits/manage.php?id=${visit.id}`;
    },


    /*
    * Save a new visit
    * */
    onClickSave: function () {


      this.$store.dispatch('addVisit', this.visitToAdd)
          .then(r => {

            // hide modal
            this.modalAddVisit.visible = false;

            // clear remark
            this.visitToAdd.remarks = "";

          })
          .catch(e => {
            alert('Failed to add a visit');
          });

    },

    onClickShowAddVisitModal: function () {
      this.visitToAdd.patient_id = this.patient.id;
      this.modalAddVisit.visible = true;
    },

    onHidingAddVisitModal: function () {
      this.modalAddVisit.visible = false;
    },

  },

}
</script>

<style scoped>

</style>
