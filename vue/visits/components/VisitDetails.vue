<template>

  <div>

    <div class="card shadow shadow-sm" v-if="patient">
      <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">
          <div>
            <!-- collapse/un-collapse button -->
            <button class="btn btn-tiny btn-warning" @click="cardCollapsed = !cardCollapsed"><i class="bi" :class="collapseButtonIcon"></i></button>

            <a :href="createPatientPageLink()" class="btn btn-tiny btn-secondary">Back to patient</a>
            <button class="btn btn-tiny btn-primary" @click="onShowEditVisit">Edit</button>
          </div><!-- left -->

          <div>
            Visit Details
          </div><!-- center -->

          <div>
            <div class="custom-control custom-switch mt-1">
              <input type="checkbox" class="custom-control-input" id="switch-status" v-model="completed">
              <label class="custom-control-label" for="switch-status">{{ statusSwitchLabel }}</label>
            </div>
          </div><!-- right -->

        </div><!-- d-flex -->


      </div>
      <div class="card-body">

        <transition name="slide-fade">

          <section v-if="!cardCollapsed">

            <div class="form-row mb-2">

              <div class="col-6 col-lg-2 mb-2 mb-lg-0">

                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Date</div>
                  </div>
                  <input type="text" class="form-control bg-white" :value="visit.visit_date" readonly>
                </div>

              </div><!-- col -->

              <div class="col-6 col-lg-4 mb-2 mb-lg-0">

                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Patient</div>
                  </div>
                  <input type="text" class="form-control bg-white" :value="patientFullName" readonly>
                </div>

              </div><!-- col -->

              <div class="col-6 col-lg-2 mb-2 mb-lg-0">

                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Age</div>
                  </div>
                  <input type="text" class="form-control bg-white" :value="patient.age" readonly>
                </div>

              </div><!-- col -->

              <div class="col-6 col-lg-2 mb-2 mb-lg-0">

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

            <!-- --- -->

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

              <div class="col">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">DBP</div>
                  </div>
                  <input type="text" class="form-control bg-white" :value="visit.dbp" readonly>
                </div>
              </div><!-- col -->

              <div class="col">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <div class="input-group-text">SBP</div>
                  </div>
                  <input type="text" class="form-control bg-white" :value="visit.sbp" readonly>
                </div>
              </div><!-- col -->


            </div><!-- row -->

            <div class="form-row mb-2">


              <div class="col">

                <div class="form-group">
                  <label>Remarks</label>
                  <textarea rows="3" class="form-control" readonly>{{ visit.remarks }}</textarea>
                </div>

              </div><!-- col -->

            </div><!-- row -->

          </section>

        </transition>

      </div><!-- card-body -->

    </div>

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

          <div class="col-auto">
            <div class="form-group">
              <label>Height (m)</label>
              <input type="number" class="form-control" v-model="visit.height">
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>Weight (kg)</label>
              <input type="number" class="form-control" v-model="visit.weight">
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>BMI (kg/m&sup2;)</label>
              <input type="number" class="form-control" :value="bmi" readonly>
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>BSA (m&sup2;)</label>
              <input type="number" class="form-control" :value="bsa" readonly>
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row justify-content-center">

          <div class="col-auto">
            <div class="form-group">
              <label>Systolic BP</label>
              <input type="number" class="form-control" v-model="visit.sbp">
            </div>
          </div><!-- col -->

          <div class="col-auto">
            <div class="form-group">
              <label>Diastolic BP</label>
              <input type="number" class="form-control" v-model="visit.dbp">
            </div>
          </div><!-- col -->

        </div><!-- row -->

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

const _ = require('lodash');

export default {
  name: "VisitDetails",
  components: {ModalWindow, DateField},

  data() {
    return {

      modalEditVisitVisible: false,
      completed: false,

      cardCollapsed: true,

    }
  },

  computed: {
    visit: function () {
      return this.$store.getters.getVisit;
    },

    patient: function () {
      return this.visit.patient;
    },

    status: function () {
      return this.$store.getters.getVisit.status;
    },


    statusSwitchLabel: function () {
      if (this.completed) return 'Completed';
      else return 'Incomplete';
    },

    patientFullName: function () {
      return this.patient.first_name + " " + this.patient.last_name;
    },


    /* BMI calculation */
    bmi: function () {
      return _.round(this.visit.weight / (this.visit.height * this.visit.height), 2);
    },

    bsa: function () {
      // https://www.nursingcenter.com/ncblog/august-2017/body-mass-index-and-body-surface-area-what-s-the-d
      return _.round(Math.sqrt(((this.visit.height / 100.0) * this.visit.weight) / 3600.0), 2);
    },

    /* card collapse icons */
    collapseButtonIcon: function () {
      if (this.cardCollapsed) return 'bi-arrow-down-short'
      else return 'bi-arrow-up-short';
    },

  },

  /*
  *
  * WATCH
  * */
  watch: {

    /*
    * Watch for the toggle, and send request accordingly
    * */
    completed: function (value) {

      if (value) {
        this.$store.dispatch('visitSetAsComplete', {visit: this.visit, status: 'COMPLETE'})
            .catch(e => {
              console.log(e);
              this.completed = false;
            });
      } else {
        this.$store.dispatch('visitSetAsComplete', {visit: this.visit, status: 'INCOMPLETE'})
            .catch(e => {
              console.log(e);
              this.completed = true;
            });
      }

    },

  },

  /*
  *
  * MOUNTED
  * */
  mounted() {

    this.completed = this.status === 'COMPLETE';

  },

  /*
  *
  * METHODS
  * */
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
      }

      console.table(visit);

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

/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}

.slide-fade-leave-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */
{
  transform: translateY(10px);
  opacity: 0;
}

</style>
