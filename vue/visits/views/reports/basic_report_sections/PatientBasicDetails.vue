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
                <div><span class="font-weight-bold">ID #{{ patient.id }}</span></div>
                <div>&mdash; {{ visit.visit_date }}</div>
              </div>
            </td>
            <td class="font-weight-bold">
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
            <span class="font-weight-bold">SBP:</span> {{ visit.sbp }} mmHg
          </td>
          <td>
            <span class="font-weight-bold">DBP:</span> {{ visit.dbp }} mmHg
          </td>
        </tr>
        </tbody>
      </table>


      <table class="table table-bordered table-sm mb-1" v-if="showExtra">
        <tbody>
        <tr>
          <td>
            <span class="font-weight-bold">DM:</span>
            <span :class="renderAbnormalBoolean(visit.dm)">{{ visit.dm | boolean }}</span>
          </td>
          <td>
            <span class="font-weight-bold">HT:</span>
            <span :class="renderAbnormalBoolean(visit.ht)">{{ visit.ht | boolean }}</span>
          </td>
          <td>
            <span class="font-weight-bold">DL:</span>
            <span :class="renderAbnormalBoolean(visit.dl)">{{ visit.dl | boolean }}</span>
          </td>
          <td v-if="showEF">
            <span class="font-weight-bold">EF:</span>
            <span>{{ visit.ef }} %</span>
          </td>
          <td>
            <span class="font-weight-bold">SMOKING:</span> {{ visit.smoking | filterSmoking }}
          </td>
          <td>
            <span class="font-weight-bold">FH:</span>
            <span :class="renderAbnormalBoolean(visit.family_history)">{{
                visit.family_history | filterFamilyHistory
              }}</span>
          </td>
          <td>
            <span class="font-weight-bold">HR:</span> {{ visit.heart_beat }}
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

import _ from 'lodash';

export default {
  name: 'PatientBasicDetails',
  components: {TheLoading},

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
      if (!_.isEmpty(this.patient.dob)) {
        const today = moment();
        const diff = moment.duration(today.diff(moment(this.patient.dob)));
        return Math.round(diff.asYears());
      }
      return '';
    },

  },

  watch: {
    patient(value) {
      if (!_.isEmpty(value)) this.loaded = true;
      else return false;
    },
  },

  mounted() {
    if (!_.isEmpty(this.patient)) this.loaded = true;
  },

  filters: {

    boolean(value) {
      if (value) return 'YES';
      return 'NO';
    },

    filterSmoking(value) {
      switch (value) {
        case 'NO':
          return 'NO';
        case 'SMOKING':
          return 'SMOKING';
        case 'JUST_QUIT':
          return 'JUST QT';
        case 'EX_SMOKER':
          return 'EX';
      }
    },

    filterFamilyHistory(value) {
      switch (value) {
        case 'Y':
          return 'YES';
        case 'N' :
          return 'NO';
      }
    },

  },
  /* -- filters -- */

  methods: {
    renderAbnormalBoolean(value) {
      if (value === true || value === 'Y') {
        return 'border-bottom border-dark';
      }
      return '';
    },


  },

};
</script>

<style scoped>
</style>
