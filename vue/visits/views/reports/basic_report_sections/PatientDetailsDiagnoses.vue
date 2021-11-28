<template>

  <div>

    <div v-if="loaded">
      <!-- section: basic -->
      <PatientBasicDetails/>

      <!-- section: lipids details -->
      <div id="section-lipids" v-if="! isLipidsEmpty">
        <table class="table table-sm table-bordered">
          <tbody>
          <tr>
            <td style="width: 20%">
              <div><span class="font-weight-bold">TC:</span> {{ lipids.tc }}</div>
            </td>
            <td style="width: 20%">
              <div><span class="font-weight-bold">LDL:</span> {{ lipids.ldl }}</div>
            </td>
            <td style="width: 20%">
              <div><span class="font-weight-bold">HDL:</span> {{ lipids.hdl }}</div>
            </td>
            <td style="width: 20%">
              <div><span class="font-weight-bold">TG:</span> {{ lipids.tg }}</div>
            </td>
            <td style="width: 20%">
              <div><span class="font-weight-bold">NHC:</span> {{ lipids.nhc }}</div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>


      <!-- section: ecg -->
      <div id="section-ecg" v-if="! isVisitECGEmpty">
        <div class="lead text-uppercase font-weight-bold">ECG Details</div>
        <table class="table table-sm table-borderless mb-1">
          <tbody>
          <tr>
            <td>
              <div class="prescription-details" v-html="visitECG.description" contenteditable="true"></div>
            </td>
          </tr>
          </tbody>
        </table>
        <hr>
      </div>


      <!-- section: clinical details -->
      <div id="section-clinical-details" class="section" v-if="visitSymptoms.length > 0">
        <div class="lead font-weight-bold text-uppercase">Clinical details</div>
        <table class="table table-sm table-borderless mb-1">
          <tbody>
          <tr v-for="item in visitSymptoms">
            <td contenteditable="true">{{ item.symptom.symptom_name }}</td>
            <td contenteditable="true" class="text-right">{{ item.duration }}</td>
          </tr>
          </tbody>
        </table>
        <hr>
      </div>

      <!-- section: differential diagnoses -->
      <div class="section-differential-diagnoses section" v-if="diffDiagnoses.length > 0">
        <div class="lead font-weight-bold text-uppercase">Differential diagnoses</div>
        <table class="table table-sm table-borderless mb-1">
          <tbody>
          <tr>
            <td contenteditable="true">
              <span class="mr-2" v-for="item in diffDiagnoses">{{ item.disease.disease }} / </span>
            </td>
          </tr>
          </tbody>
          <hr>
        </table>
      </div>
      <!-- section: differential diagnoses -->



      <!-- section: investigations -->
      <div id="section-investigations" class="section" v-if="investigations.length > 0">
        <div class="lead font-weight-bold text-uppercase">Investigations</div>
        <table class="table table-sm table-borderless mb-1">
          <tbody>
          <tr v-for="item in investigations">
            <td contenteditable="true">
              <div><span class="font-weight-bold">{{ item.investigation.investigation_name }}</span> - {{ item.remarks }}</div>
            </td>
          </tr>
          </tbody>
        </table>
        <hr>
      </div>

      <!-- section: visit problems -->
      <div id="section-problems" class="section" v-if="diagnoses.length > 0 || problems.length > 0">
        <div class="lead font-weight-bold text-uppercase">Problems & Diagnoses</div>
        <table class="table table-sm table-borderless mb-1">
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
        <hr>
      </div>
      <!-- section: visit problems -->

      <div class="section" id="section-further-investigations" v-if="furtherInvestigationsList.length > 0">
        <div class="lead font-weight-bold text-uppercase">Investigations</div>
        <table class="table table-sm table-borderless mb-1">
          <tbody>
          <tr v-for="item in furtherInvestigationsList">
            <td contenteditable="true">
              <div><span class="font-weight-bold">{{ item.investigation.investigation_name }}</span> - {{ item.remarks }}</div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>



    </div>

    <div v-else>
      <TheLoading/>
    </div>


  </div><!-- template -->


</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import TheLoading from '../../../../_common/components/TheLoading';
import PatientBasicDetails from './PatientBasicDetails';

export default {
  name: 'PatientDetailsDiagnoses',
  components: { PatientBasicDetails, TheLoading },
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

    furtherInvestigationsList() {
      return this.$store.getters.getFurtherInvestigationsList;
    },

    /* -------------------------------------------------------------------------------- */
    /* validators */
    /* -------------------------------------------------------------------------------- */

    isLipidsEmpty() {
      return this.lipids.hdl === 0 && this.lipids.ldl === 0 && this.lipids.nhc === 0 && this.lipids.tc === 0 && this.lipids.tg === 0;
    },

    isVisitECGEmpty() {
      return this.visitECG.description === '';
    },

  },
  /* -- computed -- */

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


  async mounted() {
    try {

      const visitId = this.$store.getters.getVisitId;

      await this.$store.dispatch( 'visitSymptoms_fetchAll', visitId );
      await this.$store.dispatch( 'diffDiagnoses_fetchAll', visitId );
      await this.$store.dispatch( 'visitInvestigations_fetchAll', visitId );
      await this.$store.dispatch( 'diagnoses_fetchAll', visitId );
      await this.$store.dispatch( 'visitProblems_fetchAll', visitId );
      await this.$store.dispatch( 'visitLipids_fetchAll', visitId );
      await this.$store.dispatch( 'visitECG_fetch', visitId );

      await this.$store.dispatch( "furtherInvestigations_fetchAll", visitId );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( 'Failed to load required data' );
    }

  },
  /* -- mounted -- */


};
</script>

<style>

.prescription-details > > > p {
  margin-bottom: 0 !important;
}



</style>
