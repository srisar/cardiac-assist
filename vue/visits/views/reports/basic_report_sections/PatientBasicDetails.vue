<template>

  <div>

    <div id="section-basic" class="mb-1" v-if="loaded">

      <table class="table table-sm table-bordered mb-1">

        <thead>
        <tr>
          <th>
            <div contenteditable="true" class="font-weight-bold">#{{ patient.id }} - {{ patient.first_name }} {{ patient.last_name }} ({{
                patient.gender
              }})
            </div>
          </th>

          <th class="text-right">
            <div contenteditable="true">{{ patient.dob }} ({{ patientAge }})</div>
          </th>
        </tr>
        </thead>
      </table>


      <table class="table table-bordered table-sm mb-1">
        <tbody>
        <tr>
          <td style="width: 25%">
            <div><span class="font-weight-bold">H:</span> {{ visit.height }} m</div>
          </td>

          <td style="width: 25%">
            <div><span class="font-weight-bold">W:</span> {{ visit.weight }} kg</div>
          </td>

          <td style="width: 25%">
            <div><span class="font-weight-bold">BMI:</span> {{ visit.bmi }} kg/m²</div>
          </td>

          <td style="width: 25%">
            <div><span class="font-weight-bold">SBP/DBP:</span> {{ visit.sbp }}/{{ visit.dbp }} mmHg</div>
          </td>

        </tr>
        </tbody>
      </table>


      <table class="table table-bordered table-sm mb-1">
        <tbody>
        <tr>

          <td style="width: 16.66%">
            <div><span class="font-weight-bold">DM:</span> {{ visit.dm | boolean }}</div>
          </td>

          <td style="width: 16.66%">
            <div><span class="font-weight-bold">HT:</span> {{ visit.ht | boolean }}</div>
          </td>

          <td style="width: 16.66%">
            <div><span class="font-weight-bold">DL:</span> {{ visit.dl | boolean }}</div>
          </td>

          <td style="width: 16.66%">
            <div><span class="font-weight-bold">EF:</span> {{ visit.ef }} %</div>
          </td>

          <td style="width: 16.66%">
            <div><span class="font-weight-bold">SMOK:</span> {{ visit.smoking | filterSmoking }}</div>
          </td>

          <td style="width: 16.66%">
            <div><span class="font-weight-bold">FH:</span> {{ visit.family_history | filterFamilyHistory }}</div>
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
import TheLoading from '../../../../_common/components/TheLoading';

export default {
  name: 'PatientBasicDetails',
  components: { TheLoading },
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
