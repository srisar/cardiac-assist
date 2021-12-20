<template>

  <div class="">
    <div class="card shadow shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between">

        <div>Appointments on {{ dateString }}</div>
        <div>
          <button class="btn btn-tiny btn-outline-success" @click="onClickPreviousDay()">
            <img src="/assets/images/actions/back.svg" class="icon-16" alt="Previous day">
          </button>
          <button class="btn btn-tiny btn-outline-success" @click="onClickToday()">
            <img src="/assets/images/actions/calendar.svg" class="icon-16" alt="Previous day">
          </button>
          <button class="btn btn-tiny btn-outline-success" @click="onClickNextDay()">
            <img src="/assets/images/actions/forward.svg" class="icon-16" alt="Previous day">
          </button>
        </div>

      </div>
      <div class="card-body" v-if="loaded">

        <div class="alert alert-dark text-center font-weight-bold" v-if="allEmpty">
          <img src="/assets/images/actions/warning.svg" class="icon-24" alt=""> There are no appointments on {{ dateString }}
        </div>

        <div v-if="pendingAppointments.length > 0">
          <h5 class="text-center text-uppercase">Pending</h5>
          <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="pendingAppointments" table-class="table-warning"/>
        </div><!-- section -->

        <div v-if="completedAppointments.length > 0">
          <h5 class="text-center text-uppercase">Completed</h5>
          <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="completedAppointments" table-class="table-success"/>
        </div><!-- section -->

        <div v-if="missedAppointments.length > 0">
          <h5 class="text-center text-uppercase">Missed</h5>
          <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="missedAppointments" table-class="table-danger"/>
        </div><!-- section -->

        <div v-if="cancelledAppointments.length > 0">
          <h5 class="text-center text-uppercase">Cancelled</h5>
          <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="cancelledAppointments" table-class="table-info"/>
        </div><!-- section -->

      </div><!-- card-body -->

      <div class="card-body" v-else>
        <TheLoading/>
      </div>

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>

import AppointmentsTable from "../../components/AppointmentsTable";
import {DateTime} from "luxon";
import {errorMessageBox} from '@/_common/bootbox_dialogs';
import TheLoading from "../../../_common/components/TheLoading";

export default {
  name: "SingleDayAppointments",
  components: { TheLoading, AppointmentsTable },

  data() {
    return {

      loaded: false,

      /* today's appointments */
      date: DateTime.now(),

      pendingAppointments: [],
      completedAppointments: [],
      missedAppointments: [],
      cancelledAppointments: [],
    }
  },

  computed: {
    statuses() {
      return this.$store.getters.getAppointmentStatuses;
    },

    dateString() {
      return this.date.toFormat( "yyyy-MM-dd" );
    },

    allEmpty() {
      return _.isEmpty( this.pendingAppointments )
          && _.isEmpty( this.completedAppointments )
          && _.isEmpty( this.missedAppointments )
          && _.isEmpty( this.cancelledAppointments );

    }

  },

  async mounted() {
    await this.__fetchAppointments();
  },

  methods: {

    calculateAge( dob ) {
      const today = moment();
      const diff = moment.duration( today.diff( moment( dob ) ) );
      return Math.round( diff.asYears() );
    },

    renderPatientUrl( id ) {
      return `${ getSiteURL() }/app/patients/edit.php?id=${ id }`;
    },


    async onClickNextDay() {
      this.date = this.date.plus( { days: 1 } );
      await this.__fetchAppointments();
    },

    async onClickPreviousDay() {
      this.date = this.date.minus( { days: 1 } );
      await this.__fetchAppointments();
    },

    async onClickToday() {
      this.date = DateTime.now();
      await this.__fetchAppointments();
    },

    /* invoke when status-updated emitted from appointments table */
    async onStatusUpdated() {
      await this.__fetchAppointments();
    },

    /*
    * private methods
    * */

    async __fetchAppointments() {
      try {

        this.loaded = false;

        const paramsPending = {
          date: this.dateString,
          status: this.statuses.pending
        };

        const paramsCompleted = {
          date: this.dateString,
          status: this.statuses.completed
        };

        const paramsCancelled = {
          date: this.dateString,
          status: this.statuses.cancelled
        };

        const paramsMissed = {
          date: this.dateString,
          status: this.statuses.missed
        };

        this.pendingAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsPending );
        this.completedAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsCompleted );
        this.cancelledAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsCancelled );
        this.missedAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsMissed );

        this.loaded = true;

      } catch ( e ) {
        errorMessageBox( "Failed to load appointments" );
      }
    }

  },

}
</script>

<style scoped>

</style>
