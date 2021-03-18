<template>

  <div>

    <div class="container-fluid">
      <div class="row justify-content-center">

        <div class="col-12 col-lg-7 mb-3">

          <div class="card mb-4 shadow shadow-sm">

            <div class="card-header">Patient - {{ fullName }}</div>

            <div class="card-body">

              <div class="form-row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="required">First name</label>
                    <input class="form-control" type="text" v-model.trim="patient.first_name">
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group">
                    <label class="required">Last name</label>
                    <input class="form-control" type="text" v-model.trim="patient.last_name">
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="field_sex" class="required">Gender</label>
                    <select name="" id="field_sex" class="form-control" v-model="patient.gender">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in genders" :value="key">{{ item }}</option>
                    </select>
                  </div>
                </div>

              </div><!--.row-->

              <div class="form-row">
                <div class="col-sm-4 col-md-3">

                  <div class="form-group">
                    <label>NIC</label>
                    <input class="form-control" type="text" v-model.trim="patient.nic">

                  </div>


                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Date of birth</label>
                    <DateField v-model="patient.dob"></DateField>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="field_age">Age (calculated)</label>
                    <input class="form-control" type="number" id="field_age" v-model="calculatedAge" readonly>

                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="field_phone">Phone number</label>
                    <input class="form-control" type="text" id="field_phone" v-model.trim="patient.phone">

                  </div>
                </div>

              </div><!--.row-->

              <div class="row">


              </div><!--.row-->

              <div class="form-row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" rows="4" v-model="patient.address"></textarea>

                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="field_ds_division">DS division</label>
                    <select name="" id="field_ds_division" class="form-control" v-model="patient.ds_division">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in dsDivisions" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>
              </div><!--.row-->

              <div class="form-row">


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="field_job">Job</label>
                    <select name="" id="field_job" class="form-control" v-model="patient.job">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in jobs" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="field_job_type">Job type</label>
                    <select name="" id="field_job_type" class="form-control" v-model="patient.job_type">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in jobTypes" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="field_income">Monthly income</label>
                    <input class="form-control" type="number" id="field_income" v-model.trim="patient.income">

                  </div>
                </div>
              </div><!--.row-->


              <div class="text-center">
                <button type="button" class="btn btn-success" :disabled="!formValidated" @click="onClickUpdatePatient">Update</button>
              </div>

            </div> <!--.card-body-->
          </div><!--.card-->

        </div><!-- col-->

        <div class="col-12 col-lg-5 mb-3">
          <ListVisits class="mb-3"/>

          <ListAppointments class="mb-3"/>

        </div>

      </div><!-- row -->
    </div><!-- container -->

  </div><!-- template -->


</template>

<script>

import DateField from "../../_common/components/DateField";
import * as values from '../values';
import ListVisits from "./components/ListVisits";
import ListAppointments from "./components/ListAppointments";

const _ = require('lodash');

export default {
  name      : "EditPatientView",
  components: { ListAppointments, DateField, ListVisits },

  data() {
    return {

      patientId: document.getElementById("php_patient_id").value,

      genders    : values.GENDERS,
      jobs       : values.JOBS,
      jobTypes   : values.JOB_TYPES,
      dsDivisions: values.DS_DIVISIONS
    }
  },
  /* *** DATA *** */


  computed: {

    patient: function () {
      return this.$store.getters.getPatient;
    },

    formValidated: function () {
      if ( _.isEmpty(this.patient.first_name) ) return false;
      if ( _.isEmpty(this.patient.last_name) ) return false;
      return !_.isEmpty(this.patient.gender);
    },

    calculatedAge: function () {
      return this._calculateAge()
    },

    fullName: function () {
      return this.patient.first_name + " " + this.patient.last_name;
    },

  },
  /* *** COMPUTED *** */

  mounted() {

    this.fetchPatient();

  },
  /* *** MOUNTED *** */


  methods: {

    fetchPatient: function () {

      this.$store.dispatch('fetchPatient', this.patientId)
          .then(r => {

            /*
            * after fetching patient data, fetch visits data
            * */
            this.$store.dispatch('fetchVisits')
                .catch(e => {
                  alert('Failed to get visits')
                  console.log(e)
                });


            this.$store.dispatch('fetchAppointments')
                .catch(e => {
                  alert('failed to get appointments')
                  console.log(e)
                })

          })

    },


    onClickUpdatePatient: function () {

      this.patient.age = this.calculatedAge;

      this.$store.dispatch('updatePatient', this.patient)
          .then(r => {
            alert(r.message)
          })
          .catch(e => {
            alert('Failed to update patient details')
            console.log(e)
          })

    },


    _calculateAge: function () {
      const today = moment()
      const diff = moment.duration(today.diff(moment(this.patient.dob)))
      return Math.round(diff.asYears())
    }
  },
  /* *** METHODS *** */

}
</script>

<style scoped>

</style>
