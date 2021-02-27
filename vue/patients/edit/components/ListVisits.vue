<template>

  <div>

    <div class="card">
      <div class="card-header">

        <div class="d-flex align-items-center justify-content-between">
          <div>Visits</div>
          <button class="btn btn-tiny btn-primary" @click="onClickShowAddVisitModal">Add a visit</button>
        </div>

      </div>
      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 100px">Date</th>
            <th>Remarks</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in visitsList">
            <td><a :href="createVisitLink(item)">{{ item.visit_date }}</a></td>
            <td>{{ item.remarks }}</td>
            <td>{{ item.status }}</td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->
    </div><!-- card -->

    <!-- MODAL: add new visit -->
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

          <div class="col-auto">
            <div class="form-group">
              <label>Height (m)</label>
              <input type="number" class="form-control" v-model="visitToAdd.height">
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>Weight (kg)</label>
              <input type="number" class="form-control" v-model="visitToAdd.weight">
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>BMI (kg/m&sup2;)</label>
              <input type="number" class="form-control" :value="bmi" readonly>
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>BSA (m&sup2;)</label>
              <input type="number" class="form-control" :value="bsa" readonly>
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row">

          <div class="col-auto">
            <div class="form-group">
              <label>Systolic BP</label>
              <input type="number" class="form-control" v-model="visitToAdd.sbp">
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>Diastolic BP</label>
              <input type="number" class="form-control" v-model="visitToAdd.dsp">
            </div>
          </div><!-- col -->

        </div><!-- row -->

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

const _ = require('lodash');

export default {
  name      : "ListVisits",
  components: { ModalWindow, DateField },
  data() {
    return {

      modalAddVisit: {
        visible: false,
      },

      visitToAdd: {
        visit_date: moment().format('YYYY-MM-DD'),
        remarks   : "",
        height    : 1,
        weight    : 1,
        sbp       : 0,
        dsp       : 0
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

    /* BMI calculation */
    bmi: function () {
      return _.round(this.visitToAdd.weight / (this.visitToAdd.height * this.visitToAdd.height), 2);
    },

    bsa: function () {

      // https://www.nursingcenter.com/ncblog/august-2017/body-mass-index-and-body-surface-area-what-s-the-d

      return _.round(Math.sqrt(((this.visitToAdd.height / 100.0) * this.visitToAdd.weight) / 3600.0), 2);

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


      const visit = {
        patient_id: this.patient.id,
        visit_date: this.visitToAdd.visit_date,
        remarks   : this.visitToAdd.remarks,
        height    : this.visitToAdd.height,
        weight    : this.visitToAdd.weight,
        bmi       : this.bmi,
        bsa       : this.bsa,
        dbp       : this.visitToAdd.dsp,
        sbp       : this.visitToAdd.sbp,
      }

      this.$store.dispatch('addVisit', visit)
          .then(r => {

            // hide modal
            this.modalAddVisit.visible = false;

            // clear fields
            this.visitToAdd.remarks = "";
            this.visitToAdd.height = 0;
            this.visitToAdd.weight = 0;
            this.visitToAdd.dsp = 0;
            this.visitToAdd.sbp = 0;

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
