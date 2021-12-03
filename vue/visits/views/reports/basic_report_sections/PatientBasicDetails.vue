<template>

  <div>

    <div id="section-basic" class="mb-1" v-if="loaded">

      <!-- patient details -->
      <div class="">
        <table class="table table-bordered table-sm mb-1">
          <tbody>
          <tr>
            <td>
              <div class="d-flex align-middle" style="gap: .25rem">
                <div><span class="font-weight-bold">ID</span> {{ patient.id }}</div>
                <div>&mdash; {{ visit.visit_date }}</div>
              </div>
            </td>
            <td class="w-75 font-weight-bold">
              {{ patient.first_name }} {{ patient.last_name }} &mdash; {{ patient.gender }} &mdash; {{ patientAge }}
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- visit details -->
      <table class="table table-bordered table-sm mb-1" v-if="showExtra">
        <tbody>
        <tr>
          <td>
            <span class="font-weight-bold">H:</span> {{ visit.height }} m
          </td>
          <td>
            <span class="font-weight-bold">W:</span> {{ visit.weight }} kg
          </td>
          <td>
            <span class="font-weight-bold">BMI:</span> {{ visit.bmi }} kg/m²
          </td>
          <td>
            <span class="font-weight-bold">SBP/DBP:</span> {{ visit.sbp }}/{{ visit.dbp }} mmHg
          </td>
        </tr>
        </tbody>
      </table>


      <table class="table table-bordered table-sm mb-1" v-if="showExtra">
        <tbody>
        <tr>
          <td>
            <span class="font-weight-bold">DM:</span> {{ visit.dm | boolean }}
          </td>
          <td>
            <span class="font-weight-bold">HT:</span> {{ visit.ht | boolean }}
          </td>
          <td>
            <span class="font-weight-bold">DL:</span> {{ visit.dl | boolean }}
          </td>
          <td v-if="showEF">
            <span class="font-weight-bold">EF:</span> {{ visit.ef }} %
          </td>
          <td>
            <span class="font-weight-bold">SMOKING:</span> {{ visit.smoking | filterSmoking }}
          </td>
          <td>
            <span class="font-weight-bold">FH:</span> {{ visit.family_history | filterFamilyHistory }}
          </td>
          <td>
            <span class="font-weight-bold">HB:</span> {{ visit.heart_beat }}
          </td>
        </tr>

        </tbody>
      </table>

    </div><!-- section -->

    <div v-else>
      <TheLoading/>
    </div>


  </div>

</template>

<script>

import TheLoading from '@/_common/components/TheLoading';

const _ = require( 'lodash' );

export default {
  name: 'PatientBasicDetails',
  components: { TheLoading },

  props: {
    showEF: {
      type: Boolean,
      default: true,
    },

    showExtra: {
      type: Boolean,
      default: true,
    },
  },

  data() {
    return {
      loaded: false,
    };
  },

  computed: {

    visit() {
      return this.$store.getters.getVisit;
    },

    patient() {
      return this.$store.getters.getPatient;
    },


    patientAge() {
      if ( !_.isEmpty( this.patient.dob ) ) {
        const today = moment();
        const diff = moment.duration( today.diff( moment( this.patient.dob ) ) );
        return Math.round( diff.asYears() );
      }
      return '';
    },

  },

  watch: {
    patient( value ) {
      if ( !_.isEmpty( value ) ) this.loaded = true;
      else return false;
    },
  },

  mounted() {
    if ( !_.isEmpty( this.patient ) ) this.loaded = true;
  },

  filters: {

    boolean( value ) {
      if ( value ) return 'Yes';
      return 'No';
    },

    filterSmoking( value ) {
      switch ( value ) {
        case 'NO':
          return 'No';
        case 'SMOKING':
          return 'Smoking';
        case 'JUST_QUIT':
          return 'Just quit';
        case 'EX_SMOKER':
          return 'Ex smoker';
      }
    },

    filterFamilyHistory( value ) {
      switch ( value ) {
        case 'Y':
          return 'Yes';
        case 'N' :
          return 'No';
      }
    },

  },
  /* -- filters -- */

};
</script>

<style scoped>
</style>
