<template>

  <div>

    <table class="table table-sm table-bordered">

      <!-- basic patient details -->
      <tr>
        <td colspan="3">
          <div contenteditable="true">{{ patient.first_name }} {{ patient.last_name }} ({{ patient.gender }})</div>
        </td>

        <td>
          <div contenteditable="true">{{ patient.dob }} ({{ patientAge }})</div>
        </td>
      </tr>

      <!-- basic visit details -->
      <tr>
        <td style="width: 25%">
          <div>Height: {{ visit.height }}m</div>
        </td>

        <td style="width: 25%">
          <div>Weight: {{ visit.weight }}kg</div>
        </td>

        <td style="width: 25%">
          <div>BMI: {{ visit.bmi }}kg/m²</div>
        </td>

        <td style="width: 25%">
          <div>{{ visit.dbp }} / {{ visit.sbp }}mmHg</div>
        </td>

      </tr>

      <tr>
        <td style="width: 25%">
          <div>DM: {{ visit.dm | boolean }}</div>
        </td>

        <td style="width: 25%">
          <div>HT: {{ visit.ht | boolean }}</div>
        </td>

        <td style="width: 25%">
          <div>DL: {{ visit.dl | boolean }}</div>
        </td>

        <td style="width: 25%">
          <div>EF: {{ visit.ef }}%</div>
        </td>

      </tr>

    </table>

    <div class="lead text-center text-uppercase font-weight-bold">Lipid details</div>
    <table class="table table-bordered table-sm">
      <tbody>
      <tr>
        <td>
          <div>TC: {{ lipids.tc }}</div>
        </td>
        <td>
          <div>LDL: {{ lipids.ldl }}</div>
        </td>
        <td>
          <div>HDL: {{ lipids.hdl }}</div>
        </td>
        <td>
          <div>TG: {{ lipids.tg }}</div>
        </td>
        <td>
          <div>NHC: {{ lipids.nhc }}</div>
        </td>
      </tr>
      </tbody>
    </table>

    <div class="lead text-center font-weight-bold text-uppercase">Clinical details</div>
    <table class="table table-sm table-bordered">
      <tbody>
      <tr v-for="item in visitSymptoms">
        <td>{{ item.symptom.symptom_name }}</td>
        <td>{{ item.duration }}</td>
      </tr>
      </tbody>
    </table>

    <div class="lead text-center font-weight-bold text-uppercase">Differential diagnoses</div>
    <table class="table table-sm table-bordered">
      <tbody>
      <tr>
        <td>
          <span class="mr-2" v-for="item in diffDiagnoses">{{ item.disease.disease }} / </span>
        </td>
      </tr>
      </tbody>
    </table>

    <div class="lead text-center font-weight-bold text-uppercase">Investigations</div>
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

    <div class="lead text-center font-weight-bold text-uppercase">Problems + Diagnoses</div>
    <table class="table table-sm table-bordered">
      <tbody>
      <tr v-for="item in diagnoses">
        <td>
          <div contenteditable="true">{{ item.disease.disease }}</div>
        </td>
      </tr>
      <tr v-for="item in problems">
        <td>
          <div contenteditable="true">{{ item.problem.problem }}</div>
        </td>
      </tr>
      </tbody>
    </table>

    <!-- prescriptions -->

  </div>


</template>

<script>
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";

export default {
  name: "PatientDetailsDiagnoses",

  data() {
    return {}
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
    },

    diagnoses() {
      return this.$store.getters.getVisitDiagnosisList;
    },

    problems() {
      return this.$store.getters.getVisitProblemsList;
    },

    lipids() {
      return this.$store.getters.getVisitLipids;
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

      await this.$store.dispatch("visitSymptoms_fetchAll", visitId);
      await this.$store.dispatch("diffDiagnoses_fetchAll", visitId);
      await this.$store.dispatch("visitInvestigations_fetchAll", visitId);
      await this.$store.dispatch("diagnoses_fetchAll", visitId);
      await this.$store.dispatch("visitProblems_fetchAll", visitId);
      await this.$store.dispatch("visitLipids_fetchAll", visitId);


      // window.print();

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

</style>
