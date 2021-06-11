<template>

  <div>

    <div class="card shadow shadow-sm" v-if="patient">
      <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">
          <div>

            <a :href="createPatientPageLink()" class="btn btn-tiny btn-secondary">Back to patient</a>
            <button class="btn btn-tiny btn-primary" @click="onShowEditVisit">Edit</button>
          </div><!-- left -->

          <div></div><!-- center -->

          <div>

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


          <div class="form-row mb-3 justify-content-center">

            <div class="col-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">DBP</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.dbp" readonly>
              </div>
            </div><!-- col -->

            <div class="col-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">SBP</div>
                </div>
                <input type="text" class="form-control bg-white" :value="visit.sbp" readonly>
              </div>
            </div><!-- col -->

          </div>

          <div class="form-row justify-content-center">

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

          <div class="form-row mb-2">

            <div class="col">

              <div class="form-group">
                <label>Remarks</label>
                <textarea rows="3" class="form-control" readonly>{{ visit.remarks }}</textarea>
              </div>

            </div><!-- col -->

          </div><!-- row -->

          <div class="form-row justify-content-center mb-2">
            <div class="col-4 text-center">

              <div class="form-group">
                <label>Review on</label>
                <p class="lead">{{ visit.review_in }}</p>
              </div>

            </div>
          </div>


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
    <ModalWindow :visible="modalEditVisitVisible" @close="onHideEditVisit">
      <template v-slot:title>Edit visit details</template>
      <slot>

        <div class="form-row justify-content-center">
          <div class="col-auto">

            <div class="form-group text-center">
              <label class="text-center">Date</label>
              <DateField v-model="visit.visit_date"/>
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

          <div class="col-4 text-center">

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-dm" v-model="visit.dm">
              <label class="form-check-label" for="check-dm">DM</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-ht" v-model="visit.ht">
              <label class="form-check-label" for="check-ht">HT</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-dl" v-model="visit.dl">
              <label class="form-check-label" for="check-dl">DL</label>
            </div>

          </div>
        </div>

        <div class="row justify-content-center mt-2">
          <div class="col-2 text-center">

            <div class="form-group">
              <label>EF</label>
              <input type="number" class="form-control" v-model="visit.ef">
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

export default {
  name: "BasicView",
  components: {DateField, ModalWindow,},

  data() {
    return {
      modalEditVisitVisible: false,
      completed: false,
    }
  },

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
      if (this.completed) return 'Completed';
      else return 'Incomplete';
    },

    /* status switch background color */
    statusAlertBgColorClass() {
      if (this.completed) return "alert-success";
      else return "alert-warning";
    },


    patientFullName() {
      return this.patient.first_name + " " + this.patient.last_name;
    },


    /* BMI calculation */
    bmi() {
      return _.round(this.visit.weight / (this.visit.height * this.visit.height), 2);
    },

    bsa() {
      // https://www.nursingcenter.com/ncblog/august-2017/body-mass-index-and-body-surface-area-what-s-the-d
      return _.round(Math.sqrt(((this.visit.height / 100.0) * this.visit.weight) / 3600.0), 2);
    },


    visitDl() {
      return this.visit.dl ? 'YES' : 'NO'
    },
    visitDm() {
      return this.visit.dm ? 'YES' : 'NO'
    },
    visitHt() {
      return this.visit.ht ? 'YES' : 'NO'
    },

  },


  watch: {

    /*
    * Watch for the toggle, and send request accordingly
    * */
    completed: function (value) {

      if (value) {
        this.$store.dispatch('visitSetAsComplete', {visit: this.visit, status: 'COMPLETE'})
            .catch(e => {
              this.completed = false;
            });
      } else {
        this.$store.dispatch('visitSetAsComplete', {visit: this.visit, status: 'INCOMPLETE'})
            .catch(e => {
              this.completed = true;
            });
      }

    },

    status: function (value) {
      this.completed = value === 'COMPLETE'
    }


  },


  mounted() {
    //
  },

  methods: {


    /*
    * Modal event handlers
    * */
    onShowEditVisit: function () {
      this.modalEditVisitVisible = true;
    },

    onHideEditVisit: function () {
      this.modalEditVisitVisible = false;
    },


    onUpdateVisitDetails: function () {

      const visit = {
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
      }


      this.$store.dispatch('updateVisit', visit)
          .then(() => {

            this.modalEditVisitVisible = false;

          })
          .catch(e => {
            alert('Failed to update visit details');
            console.log(e);
          })

    },

    createPatientPageLink: function () {
      return `${getSiteURL()}/app/patients/edit.php?id=${this.patient.id}`;
    },

  },

}
</script>

<style scoped>
</style>
