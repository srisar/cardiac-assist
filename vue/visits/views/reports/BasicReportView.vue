<template>

  <div v-if="loaded">

    <div class="paper">

      <div class="lead mb-3">Dr Arulnithy's Cardiac Clinic</div>

      <table class="table table-sm table-bordered">

        <!-- basic patient details -->
        <tr>
          <td colspan="3">
            <div contenteditable="true" class="lead"> {{ patient.first_name }} {{ patient.last_name }} ({{ patient.gender }})</div>
          </td>

          <td style="width: 25%">
            <div class="lead">{{ patient.dob }} ({{ patientAge }})</div>
          </td>
        </tr>

        <!-- basic visit details -->
        <tr>
          <td style="width: 25%">
            <div class="lead">Height</div>
            <div>{{ visit.height }}</div>
          </td>

          <td style="width: 25%">
            <div class="lead">Weight</div>
            <div>{{ visit.weight }}</div>
          </td>

          <td style="width: 25%">
            <div class="lead">BMI (kg/m²)</div>
            <div>{{ visit.bmi }}</div>
          </td>

          <td style="width: 25%">
            <div class="lead">DBP/SBP</div>
            <div>{{ visit.dbp }} / {{ visit.sbp }}</div>
          </td>

        </tr>

        <tr>
          <td style="width: 25%">
            <div class="lead">DM</div>
            <div>{{ visit.dm | boolean }}</div>
          </td>

          <td style="width: 25%">
            <div class="lead">HT</div>
            <div>{{ visit.ht | boolean }}</div>
          </td>

          <td style="width: 25%">
            <div class="lead">DL</div>
            <div>{{ visit.dl | boolean }}</div>
          </td>

          <td style="width: 25%">
            <div class="lead">EF</div>
            <div>{{ visit.ef }}</div>
          </td>

        </tr>

      </table>

      <div class="lead text-center font-weight-bold">Clinical details</div>
      <table class="table table-sm table-bordered">
        <tbody>
        <tr v-for="item in visitSymptoms">
          <td>{{ item.symptom.symptom_name }}</td>
          <td>{{ item.duration }}</td>
        </tr>
        </tbody>
      </table>

      <div class="lead text-center font-weight-bold">Differential diagnoses</div>
      <table class="table table-sm table-bordered">
        <tbody>
        <tr v-for="item in diffDiagnoses">
          <td>{{ item.disease.disease }}</td>
        </tr>
        </tbody>
      </table>

      <div class="lead text-center font-weight-bold">Investigations</div>
      <table class="table table-sm table-bordered">
        <tbody>
        <tr v-for="item in investigations">
          <td>
            <div class="font-weight-bold">{{ item.investigation.investigation_name }}</div>
            <div>{{ item.remarks }}</div>
          </td>
        </tr>
        </tbody>
      </table>


    </div><!-- paper -->

  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "BasicReportView",

  data() {
    return {
      //
    }
  },

  computed: {

    visit() {
      return this.$store.getters.getVisit;
    },

    patient() {
      return this.$store.getters.getPatient;
    },

    loaded() {
      return this.patient !== undefined && this.visit !== undefined;
    },

    patientAge() {
      if (!_.isEmpty(this.patient.dob)) {
        const today = moment();
        const diff = moment.duration(today.diff(moment(this.patient.dob)));
        return Math.round(diff.asYears());
      }
      return "";
    },

    /* loaded modules */
    visitSymptoms() {
      return this.$store.getters.getVisitSymptomsList;
    },

    diffDiagnoses() {
      return this.$store.getters.getDifferentialDiagnosisList;
    },

    investigations() {
      return this.$store.getters.getVisitInvestigationsList;
    }

  },

  filters: {
    boolean(value) {
      if (value) return "Yes";
      return "No";
    }

  },


  async mounted() {
    try {

      const visitId = this.$store.getters.getVisitId;

      /* fetch visit symptoms (clinical details) */
      await this.$store.dispatch("visitSymptoms_fetchAll", visitId);
      /* fetch differential diagnoses */
      await this.$store.dispatch("diffDiagnoses_fetchAll", visitId);
      /* fetch visit investigations */
      await this.$store.dispatch("visitInvestigations_fetchAll", visitId);

    } catch (e) {
      errorMessageBox("Failed to load required data");
    }

  },

  methods: {
    //
  },

}
</script>

<style scoped>

@page {
  size: A5;
}

.paper {
  border: solid 1px #cccccc;
  padding: 5pt;
  box-shadow: 0 0 10px #cccccc;
}

@media print {

  .paper {
    font-size: 14pt !important;
    border: none;
    padding: 20pt 0 0 0;
  }

}


</style>
