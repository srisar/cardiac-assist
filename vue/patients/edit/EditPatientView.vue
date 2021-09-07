<template>

  <div>

    <div class="container">
      <div class="form-row justify-content-center">

        <div class="col-12 col-lg-6 mb-3">

          <div class="card mb-4 shadow shadow-sm">

            <div class="card-header">Patient - {{ fullName }}</div>

            <div class="card-body">

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label class="required">First name</label>
                    <input class="form-control" type="text" v-model.trim="patient.first_name">
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label class="required">Last name</label>
                    <input class="form-control" type="text" v-model.trim="patient.last_name">
                  </div>
                </div>


              </div><!--.row-->


              <div class="form-row">

                <div class="col">
                  <div class="form-group">
                    <label class="required">Gender</label>
                    <select class="form-control" v-model="patient.gender">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in genders" :value="key">{{ item }}</option>
                    </select>
                  </div>
                </div>


                <div class="col">
                  <div class="form-group">
                    <label>Date of birth</label>
                    <DateField v-model="patient.dob"></DateField>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label for="field_age">Age</label>
                    <input class="form-control" type="number" id="field_age" v-model="patient.age">
                  </div>
                </div>

              </div><!-- row -->

              <div class="form-row">

                <div class="col">
                  <div class="form-group">
                    <label>NIC</label>
                    <input class="form-control" type="text" v-model.trim="patient.nic">
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label for="field_phone">Phone number</label>
                    <input class="form-control" type="text" id="field_phone" v-model.trim="patient.phone">
                  </div>
                </div>

              </div><!--.row-->


              <div class="form-row">

                <div class="col">
                  <div class="form-group">
                    <label>DS division</label>
                    <select class="form-control" v-model="patient.ds_division">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in dsDivisions" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>

              </div><!-- row -->

              <div class="form-row">

                <div class="col">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" rows="4" v-model="patient.address"></textarea>
                  </div>
                </div>

              </div><!--.row-->


              <div class="form-row">

                <div class="col">
                  <div class="form-group">
                    <label>Job</label>
                    <select id="field_job" class="form-control" v-model="patient.job">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in jobs" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label>Job type</label>
                    <select id="field_job_type" class="form-control" v-model="patient.job_type">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in jobTypes" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="field_income">Monthly income</label>
                    <input class="form-control" type="number" id="field_income" v-model.trim="patient.income">

                  </div>
                </div>
              </div><!--.row-->


              <div class="text-center">
                <button type="button" class="btn btn-success" :disabled="!formValidated" @click="onUpdatePatient()">
                  <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
                </button>
              </div>

            </div> <!--.card-body-->
          </div><!--.card-->

          <div class="mt-3">
            Click here to delete this patient.
          </div>

        </div><!-- col-->


        <!-- start: sidebar column -->

        <div class="col-12 col-lg-6 mb-3">
          <ListVisits class="mb-3"/>
          <ListAppointments class="mb-3"/>
        </div>

        <!-- end: sidebar column -->

      </div><!-- row -->
    </div><!-- container -->

    <div class="d-none">
      {{ calculatedAge }} {{ calculatedDob }}
    </div>


  </div><!-- template -->


</template>

<script>

import {errorMessageBox, successMessageBox} from '@/_common/bootbox_dialogs';
import DateField from '@/_common/components/DateField';
import * as values from '../values';
import ListAppointments from './components/ListAppointments';
import ListVisits from './components/ListVisits';

const _ = require( 'lodash' );

export default {
  name: 'EditPatientView',
  components: { ListAppointments, DateField, ListVisits },

  data() {
    return {

      patientId: document.getElementById( 'php_patient_id' ).value,

      genders: values.GENDERS,
      jobs: values.JOBS,
      jobTypes: values.JOB_TYPES,
      dsDivisions: values.DS_DIVISIONS,
    };
  },
  /* -- data -- */


  computed: {

    patient() {
      return this.$store.getters.getPatient;
    },

    formValidated() {
      if ( _.isEmpty( this.patient.first_name ) ) return false;
      if ( _.isEmpty( this.patient.last_name ) ) return false;
      return !_.isEmpty( this.patient.gender );
    },

    calculatedAge: function () {
      const today = moment();
      const diff = moment.duration( today.diff( moment( this.patient.dob ) ) );
      let years = Math.round( diff.asYears() );
      this.patient.age = years;
      return years;
    },

    calculatedDob() {
      let date = moment().subtract( this.patient.age, 'years' ).format( 'YYYY-MM-DD' );
      this.patient.dob = date;
      return date;
    },

    fullName() {
      return this.patient.first_name + ' ' + this.patient.last_name;
    },

  },
  /* -- computed -- */


  mounted() {

    this.fetchPatient();

  },
  /* -- mounted -- */


  methods: {

    async fetchPatient() {

      try {
        await this.$store.dispatch( 'patient_fetch', this.patientId );
        await this.$store.dispatch( 'visits_fetchAll', this.patientId );
        await this.$store.dispatch( 'appointments_fetchAll', this.patient.id );
      } catch ( e ) {
        errorMessageBox( 'Failed to fetch patient details' );
      }
    },


    async onUpdatePatient() {

      try {
        this.patient.age = this.calculatedAge;
        await this.$store.dispatch( 'patient_update', this.patient );

        successMessageBox( 'Patient details updated' );

      } catch ( e ) {
        errorMessageBox( 'Failed to update patient details' );
      }
    },

    _calculateAge() {
      const today = moment();
      const diff = moment.duration( today.diff( moment( this.patient.dob ) ) );
      return Math.round( diff.asYears() );
    },
  },
  /* -- methods -- */

};
</script>

<style scoped>

</style>
