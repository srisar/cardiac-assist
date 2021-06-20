<template>

  <div>

    <!-- section: basic -->
    <div id="section-basic">
      <table class="table table-sm table-bordered">
        <!-- basic patient details -->
        <tr>
          <td colspan="3">
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
    </div>

    <!-- section: lipids details -->
    <div id="section-lipids" v-if="! isLipidsEmpty">
      <div class="lead text-uppercase font-weight-bold">Lipid details</div>
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
    </div>


    <!-- section: ecg -->
    <div id="section-ecg" v-if="! isVisitECGEmpty">
      <div class="lead text-uppercase font-weight-bold">ECG Details</div>
      <table class="table table-bordered table-sm">
        <tbody>
        <tr>
          <td>
            <div v-html="visitECG.description" contenteditable="true"></div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>


    <!-- section: clinical details -->
    <div id="section-clinical-details" class="section">
      <div class="lead font-weight-bold text-uppercase">Clinical details</div>
      <table class="table table-sm table-bordered">
        <tbody>
        <tr v-for="item in visitSymptoms">
          <td contenteditable="true">{{ item.symptom.symptom_name }}</td>
          <td contenteditable="true" class="text-right">{{ item.duration }}</td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="lead font-weight-bold text-uppercase">Differential diagnoses</div>
    <table class="table table-sm table-bordered">
      <tbody>
      <tr>
        <td contenteditable="true">
          <span class="mr-2" v-for="item in diffDiagnoses">{{ item.disease.disease }} / </span>
        </td>
      </tr>
      </tbody>
    </table>

    <!-- section: investigations -->
    <div id="section-investigations" class="section">
      <div class="lead font-weight-bold text-uppercase">Investigations</div>
      <table class="table table-sm table-bordered">
        <tbody>
        <tr v-for="item in investigations">
          <td contenteditable="true">
            <div><span class="font-weight-bold">{{ item.investigation.investigation_name }}</span> - {{ item.remarks }}</div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <!-- section: visit problems -->
    <div id="section-problems" class="section">
      <div class="lead font-weight-bold text-uppercase">Problems + Diagnoses</div>
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
    </div>

  </div><!-- template -->


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
    },

    visitECG() {
      return this.$store.getters.getVisitECG;
    },

    /* -------------------------------------------------------------------------------- */
    /* validators */
    /* -------------------------------------------------------------------------------- */

    isLipidsEmpty() {
      return this.lipids.hdl === 0 && this.lipids.ldl === 0 && this.lipids.nhc === 0 && this.lipids.tc === 0 && this.lipids.tg === 0;
    },

    isVisitECGEmpty() {
      return this.visitECG.description === "";
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
      await this.$store.dispatch("visitECG_fetch", visitId);


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
