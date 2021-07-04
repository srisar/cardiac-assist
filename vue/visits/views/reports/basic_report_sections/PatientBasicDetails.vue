<template>

  <div>

    <div id="section-basic" class="mb-2" v-if="loaded">
      <table class="table table-sm table-bordered">
        <!-- basic patient details -->
        <tr>
          <td colspan="4">
            <div contenteditable="true" class="font-weight-bold">#{{ patient.id }} - {{ patient.first_name }} {{ patient.last_name }} ({{
                patient.gender
              }})
            </div>
          </td>

          <td>
            <div contenteditable="true">{{ patient.dob }} ({{ patientAge }})</div>
          </td>
        </tr>

        <!-- basic visit details -->
        <tr>
          <td style="width: 20%">
            <div><span class="font-weight-bold">H:</span> {{ visit.height }} m</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">W:</span> {{ visit.weight }} kg</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">BMI</span> {{ visit.bmi }} kg/m²</div>
          </td>

          <td style="width: 20%">
            <div>{{ visit.dbp }} / {{ visit.sbp }} mmHg</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">DM:</span> {{ visit.dm | boolean }}</div>
          </td>

        </tr>

        <tr>


          <td style="width: 20%">
            <div><span class="font-weight-bold">HT:</span> {{ visit.ht | boolean }}</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">DL:</span> {{ visit.dl | boolean }}</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">EF:</span> {{ visit.ef }} %</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">SMO:</span> {{ visit.smoking | filterSmoking }}</div>
          </td>

          <td style="width: 20%">
            <div><span class="font-weight-bold">FH:</span> {{ visit.family_history | filterFamilyHistory }}</div>
          </td>

        </tr>

        <tr>


        </tr>

      </table>
    </div>

    <div v-else>
      <TheLoading/>
    </div>


  </div>

</template>

<script>
import TheLoading from "../../../../_common/components/TheLoading";

export default {
  name: "PatientBasicDetails",
  components: { TheLoading },
  data() {
    return {
      loaded: false
    }
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
      return "";
    },

  },

  watch: {
    patient( value ) {
      if ( !_.isEmpty( value ) ) this.loaded = true;
      else return false;
    }
  },

  mounted() {
    if ( !_.isEmpty( this.patient ) ) this.loaded = true;
  },

  filters: {

    boolean( value ) {
      if ( value ) return "Yes";
      return "No";
    },

    filterSmoking( value ) {
      switch ( value ) {
        case "NO":
          return "No";
        case "SMOKING":
          return "Smoking";
        case "JUST_QUIT":
          return "Just quit";
        case "EX_SMOKER":
          return "Ex smoker";
      }
    },

    filterFamilyHistory( value ) {
      switch ( value ) {
        case "Y":
          return "Yes";
        case "N" :
          return "No";
      }
    }

  },
  /* -- filters -- */

}
</script>

<style scoped>

.border, table, tr, td {
  border: solid 1px black !important;
}

hr {
  border-top: solid 1px black !important;
}


</style>
