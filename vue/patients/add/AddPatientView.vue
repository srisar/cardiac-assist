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
                    <label for="field_age">Age</label>
                    <input class="form-control" type="number" id="field_age" v-model="patient.age">

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
                <button type="button" class="btn btn-success" :disabled="!formValidated" @click="onClickSave">Save</button>
              </div>

            </div> <!--.card-body-->
          </div><!--.card-->

        </div><!-- col-->

      </div><!-- row -->
    </div><!-- container -->

    <div class="d-none">
      {{ calculatedAge }} {{ calculatedDob }}
    </div>

  </div><!-- template -->

</template>

<script>

import DateField from '../../_common/components/DateField';
import * as values from '../values';
import store from './store';

const _ = require( 'lodash' );

export default {
  name: 'AddPatientView',
  components: { DateField },
  store: store,

  data() {
    return {

      patient: {
        id: '',
        first_name: '',
        last_name: '',
        dob: moment().format( 'YYYY-MM-DD' ),
        age: 0,
        address: '',
        ds_division: '',
        nic: '',
        phone: '',
        gender: '',
        job: '',
        job_type: '',
        income: 0,
        status: '',
      },

      genders: values.GENDERS,
      jobs: values.JOBS,
      jobTypes: values.JOB_TYPES,
      dsDivisions: values.DS_DIVISIONS,

    };
  },

  computed: {


    formValidated: function() {
      if( _.isEmpty( this.patient.first_name ) ) return false;
      if( _.isEmpty( this.patient.last_name ) ) return false;
      return !_.isEmpty( this.patient.gender );
    },

    fullName: function() {
      return this.patient.first_name + ' ' + this.patient.last_name;
    },

    calculatedAge: function() {
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

  },

  mounted() {
    //
  },

  methods: {

    onClickSave: function() {

      this.$store.dispatch( 'savePatient', this.patient )
          .then( r => {
            const patientId = r.data.id;
            redirect( `${ getSiteURL() }/app/patients/edit.php?id=${ patientId }` );
          } )
          .catch( e => {
            alert( 'Failed to save patient' );
          } );

    },

  },
};
</script>

<style scoped>

</style>
