<template>

  <div>

    <div class="card shadow shadow-sm" v-if="patient">
      <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">
          <div>

            <a :href="createPatientPageLink()" class="btn btn-tiny btn-outline-primary">
              <img src="/assets/images/actions/back.svg" class="icon-16" alt=""> Back to patient
            </a>

          </div><!-- left -->

          <div></div><!-- center -->

          <div>
            <button class="btn btn-tiny btn-outline-secondary" @click="modalEditVisitVisible = true">
              <img src="/assets/images/actions/edit.svg" class="icon-16" alt=""> Edit
            </button>
          </div><!-- right -->

        </div><!-- d-flex -->


      </div><!-- card-header -->

      <div class="card-body">

        <section>


          <div class="form-row justify-content-center mb-2">
            <div class="col-4">

              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Date</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.visit_date" readonly>
              </div>

            </div>
          </div>

          <div class="form-row mb-2">

            <div class="col-6">

              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Patient</div>
                </div>
                <input type="text" class="form-control bg-white" :value="patientFullName" readonly>
              </div>

            </div><!-- col -->

            <div class="col-3">

              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Age</div>
                </div>
                <input type="text" class="form-control bg-white" :value="patient.age" readonly>
              </div>

            </div><!-- col -->

            <div class="col-3">

              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Gender</div>
                </div>
                <input type="text" class="form-control bg-white" :value="patient.gender" readonly>
              </div>

            </div><!-- col -->


            <div class="col-12 col-lg-2 mb-2 mb-lg-0 text-lg-right text-center">
            </div><!-- col -->

          </div><!-- row -->


          <div class="form-row mb-2">

            <div class="col">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Height (m)</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.height" readonly>
              </div>
            </div><!-- col -->

            <div class="col">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Weight (kg)</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.weight" readonly>
              </div>
            </div><!-- col -->

            <div class="col">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">BMI (kg/m&sup2;)</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.bmi" readonly>
              </div>
            </div><!-- col -->

            <div class="col">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">BSA (m&sup2;)</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.bsa" readonly>
              </div>
            </div><!-- col -->


          </div><!-- row -->


          <div class="form-row mb-2 justify-content-center">

            <div class="col-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">DBP/SBP (mmHg)</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.dbp + '/' + visit.sbp" readonly>
              </div>
            </div><!-- col -->

          </div>

          <div class="form-row justify-content-center mb-2">

            <div class="col-2">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">DM</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visitDm" readonly>
              </div>
            </div>
            <div class="col-2">

              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">HT</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visitHt" readonly>
              </div>
            </div>

            <div class="col-2">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">DL</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visitDl" readonly>
              </div>
            </div>

            <div class="col-2">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">EF</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.ef" readonly>
              </div>
            </div>

          </div><!-- row -->


          <div class="form-row justify-content-center mb-2">

            <div class="col-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Smoking</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.smoking | filterSmoking" readonly>
              </div>
            </div><!-- col -->

            <div class="col-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Family history</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.family_history | filterFamilyHistory" readonly>
              </div>
            </div><!-- col -->

          </div>


          <div class="form-row mb-2">

            <div class="col">

              <div class="form-group">
                <label>Remarks</label>
                <textarea rows="3" class="form-control bg-white" readonly>{{ visit.remarks }}</textarea>
              </div>

            </div><!-- col -->

          </div><!-- row -->

          <div class="form-row justify-content-center mb-2" v-if="visit.review_in">

            <div class="col-4 text-center">

              <div class="form-group">
                <div class="text-center">Review on</div>
                <p class="review-on">{{ visit.review_in }}</p>
              </div>

            </div><!-- col -->

          </div><!-- row -->


          <div class="row mb-2 justify-content-center">

            <div class="col-6 text-center">

              <div class="alert" :class="statusAlertBgColorClass">
                <div class="custom-control custom-switch mt-1">
                  <input type="checkbox" class="custom-control-input" id="switch-status" v-model="completed">
                  <label class="custom-control-label text-uppercase" for="switch-status">{{ statusSwitchLabel }}</label>
                </div>
              </div>

            </div>

          </div>

        </section>

      </div><!-- card-body -->

    </div>


    <!-- --------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <!-- EDIT Modal: Visit Details -->
    <ModalWindow :visible="modalEditVisitVisible" @close="modalEditVisitVisible = false">
      <template v-slot:title>Edit visit details</template>
      <slot>

        <div class="form-row justify-content-center">
          <div class="col-auto">

            <div class="form-group text-center">
              <label class="text-center">Date</label>
              <DateField class="text-center" v-model="visit.visit_date"/>
            </div>

          </div>
        </div>

        <div class="form-row justify-content-center">

          <div class="col">
            <div class="form-group">
              <label>Height (m)</label>
              <input type="number" class="form-control" v-model="visit.height">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Weight (kg)</label>
              <input type="number" class="form-control" v-model="visit.weight">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>BMI (kg/m&sup2;)</label>
              <input type="number" class="form-control" :value="bmi" readonly>
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>BSA (m&sup2;)</label>
              <input type="number" class="form-control" :value="bsa" readonly>
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Systolic BP</label>
              <input type="number" class="form-control" v-model="visit.sbp">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Diastolic BP</label>
              <input type="number" class="form-control" v-model="visit.dbp">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row justify-content-center">

          <div class="col-6 text-center">

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-dm" v-model="visit.dm">
              <label class="form-check-label" for="check-dm">Diabetes</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-ht" v-model="visit.ht">
              <label class="form-check-label" for="check-ht">Hypertension</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-dl" v-model="visit.dl">
              <label class="form-check-label" for="check-dl">Dyslipidemia</label>
            </div>

          </div>
        </div>

        <div class="row justify-content-center mt-2">
          <div class="col-4 text-center">

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Ejection fraction</span>
              </div>
              <input type="number" class="form-control" v-model="visit.ef">
            </div>

          </div>
        </div>

        <div class="form-row justify-content-center mt-2">
          <div class="col-auto">

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Smoking</span>
              </div>
              <select v-model="visit.smoking" class="custom-select">
                <option v-for="(item, key) in smokingOptions" :value="key">{{ item }}</option>
              </select>
            </div>

          </div>

          <div class="col-auto">

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Family history</span>
              </div>
              <select v-model="visit.family_history" class="custom-select">
                <option v-for="(item, key) in familyHistoryOptions" :value="key">{{ item }}</option>
              </select>
            </div>

          </div>

        </div>


        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="visit.remarks"></textarea>
            </div>

          </div>
        </div>

        <div class="row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onUpdateVisitDetails">Update</button>
          </div>
        </div>


      </slot>
    </ModalWindow><!-- EDIT Modal: Visit Details-->

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";
import DateField from "../../_common/components/DateField";
import {errorMessageBox} from "../../_common/bootbox_dialogs";

export default {
  name: "BasicView",
  components: { DateField, ModalWindow, },

  data() {
    return {
      modalEditVisitVisible: false,
      completed: false,

      /* dropdown values */
      familyHistoryOptions: {
        "Y": "Yes",
        "N": "No"
      },

      smokingOptions: {
        "NO": "No",
        "SMOKING": "Smoking",
        "EX_SMOKER": "Ex smoker",
        "JUST_QUIT": "Just quit",
      }

    }
  },
  /* -- data -- */

  computed: {

    visit() {
      return this.$store.getters.getVisit;
    },

    patient() {
      return this.visit.patient;
    },

    status() {
      return this.$store.getters.getVisit.status;
    },


    /* status switch label */
    statusSwitchLabel() {
      if ( this.completed ) return "Completed";
      else return "Incomplete";
    },

    /* status switch background color */
    statusAlertBgColorClass() {
      if ( this.completed ) return "alert-success";
      else return "alert-warning";
    },


    patientFullName() {
      return this.patient.first_name + " " + this.patient.last_name;
    },


    /* BMI calculation */
    bmi() {
      return _.round( this.visit.weight / ( this.visit.height * this.visit.height ), 2 );
    },

    bsa() {
      // https://www.nursingcenter.com/ncblog/august-2017/body-mass-index-and-body-surface-area-what-s-the-d
      return _.round( Math.sqrt( ( ( this.visit.height / 100.0 ) * this.visit.weight ) / 3600.0 ), 2 );
    },


    visitDl() {
      return this.visit.dl ? "YES" : "NO"
    },
    visitDm() {
      return this.visit.dm ? "YES" : "NO"
    },
    visitHt() {
      return this.visit.ht ? "YES" : "NO"
    },

  },
  /* -- computed -- */


  watch: {

    /*
    * Watch for the toggle, and send request accordingly
    * */
    completed: function ( value ) {

      if ( value ) {
        this.$store.dispatch( "visit_setStatus", { visit_id: this.visit.id, status: "COMPLETE" } )
            .catch( () => {
              this.completed = false;
            } );
      } else {
        this.$store.dispatch( "visit_setStatus", { visit_id: this.visit.id, status: "INCOMPLETE" } )
            .catch( () => {
              this.completed = true;
            } );
      }

    },

    status: function ( value ) {
      this.completed = value === "COMPLETE";
    }


  },
  /* -- watch -- */

  filters: {

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


  methods: {


    async onUpdateVisitDetails() {

      try {

        const params = {
          id: this.visit.id,
          visit_date: this.visit.visit_date,
          remarks: this.visit.remarks,
          height: this.visit.height,
          weight: this.visit.weight,
          bmi: this.bmi,
          bsa: this.bsa,
          dbp: this.visit.dbp,
          sbp: this.visit.sbp,
          dm: this.visit.dm,
          ht: this.visit.ht,
          dl: this.visit.dl,
          ef: this.visit.ef,
          family_history: this.visit.family_history,
          smoking: this.visit.smoking,
        };

        await this.$store.dispatch( "visit_update", params );
        this.modalEditVisitVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to update visit details" );
      }

    },

    createPatientPageLink: function () {
      return `${ getSiteURL() }/app/patients/edit.php?id=${ this.patient.id }`;
    },

  },
  /* -- methods -- */

}
</script>

<style scoped>

.review-on {
  font-size: 2em;
}

</style>
