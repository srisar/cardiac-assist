<template>

  <div>
    <div class="container">
      <div class="row">
        <div class="col">

          <div class="card shadow shadow-sm mb-3">
            <div class="card-header">Today's appointments ({{ today }})</div>
            <div class="card-body">


              <div v-if="todayPendingAppointments.length > 0">
                <h5 class="text-center text-uppercase">Pending</h5>
                <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="todayPendingAppointments" table-class="table-warning"/>
              </div><!-- section -->

              <div v-if="todayCompletedAppointments.length > 0">
                <h5 class="text-center text-uppercase">Completed</h5>
                <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="todayCompletedAppointments" table-class="table-success"/>
              </div><!-- section -->

              <div v-if="todayMissedAppointments.length > 0">
                <h5 class="text-center text-uppercase">Missed</h5>
                <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="todayMissedAppointments" table-class="table-danger"/>
              </div><!-- section -->

              <div v-if="todayCancelledAppointments.length > 0">
                <h5 class="text-center text-uppercase">Cancelled</h5>
                <AppointmentsTable @status-updated="onStatusUpdated()" :appointments="todayCancelledAppointments" table-class="table-info"/>
              </div><!-- section -->

            </div>
          </div><!-- card -->

          <div class="card shadow shadow-sm mb-3">
            <div class="card-header">{{ customDateRangeLabel }}</div>
            <div class="card-body">

              <div class="mb-3 text-center">
                <button class="btn btn-sm btn-primary" @click="modalCustomDateRange.visible=true">Choose date range</button>
              </div>

              <div v-if="appointmentsBetweenDates.length > 0">

                <div class="mb-3">

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="chk_all" name="chk_status" value="ALL" v-model="checkStatus">
                    <label class="form-check-label" for="chk_all">
                      All
                    </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="chk_pending" name="chk_status" value="PENDING" v-model="checkStatus">
                    <label class="form-check-label" for="chk_pending">
                      Pending
                    </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="chk_completed" name="chk_status" value="COMPLETED" v-model="checkStatus">
                    <label class="form-check-label" for="chk_completed">
                      Completed
                    </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="chk_cancelled" name="chk_status" value="CANCELLED" v-model="checkStatus">
                    <label class="form-check-label" for="chk_cancelled">
                      Cancelled
                    </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="chk_missed" name="chk_status" value="MISSED" v-model="checkStatus">
                    <label class="form-check-label" for="chk_missed">
                      Missed
                    </label>
                  </div>
                </div><!-- filter radio buttons -->

                <AppointmentsTable @status-updated="onBetweenDatesStatusUpdated()" :appointments="filteredAppointmentsBetweenDates"/>
              </div><!-- section -->

              <div v-else class="text-center">
                No results.
              </div>


            </div>
          </div>


        </div><!-- col -->
      </div><!-- row -->
    </div><!-- container -->


    <ModalWindow :visible="modalCustomDateRange.visible" @close="modalCustomDateRange.visible = false">

      <div class="form-row justify-content-center">
        <div class="col-4">
          <div class="form-group">
            <label>Date range</label>
            <DateRangeField v-model="dateRange" :max-date="modalCustomDateRange.maxDate"/>
          </div>
        </div>
      </div>

      <div class="text-center">
        <button class="btn btn-primary" @click="onCustomDateRangeChoice()">
          <img src="/assets/images/actions/done.svg" class="icon-24" alt=""> Choose
        </button>
      </div>

    </ModalWindow>

  </div><!-- template -->

</template>

<script>
import AppointmentsTable from "./components/AppointmentsTable";
import DateRangeField from "../_common/components/DateRangeField";
import ModalWindow from "../_common/components/ModalWindow";

export default {
  name: "AppointmentsView",
  components: { ModalWindow, DateRangeField, AppointmentsTable },
  data() {
    return {

      /* custom date range appointments */
      modalCustomDateRange: {
        visible: false,
        maxDate: moment().format( "YYYY-MM-DD" ),
      },
      dateRange: {
        startDate: moment().format( "YYYY-MM-DD" ),
        endDate: moment().format( "YYYY-MM-DD" )
      },
      checkStatus: "ALL",
      appointmentsBetweenDates: [],
      customDateRangeLabel: "Appointments between dates",

      /* today's appointments */
      today: moment().format( "YYYY-MM-DD" ),

      todayPendingAppointments: [],
      todayCompletedAppointments: [],
      todayMissedAppointments: [],
      todayCancelledAppointments: [],


    }
  },


  computed: {
    statuses() {
      return this.$store.getters.getAppointmentStatuses;
    },

    filteredAppointmentsBetweenDates() {

      if ( this.checkStatus === "ALL" ) return this.appointmentsBetweenDates;

      return _.filter( this.appointmentsBetweenDates, ( o ) => {
        return o.status === this.checkStatus;
      } );

    }

  },

  filters: {},

  async mounted() {

    try {
      await this.__fetchAppointments();
    } catch ( e ) {
    }

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

    async onStatusUpdated() {
      await this.__fetchAppointments();
    },

    async onBetweenDatesStatusUpdated(){
      try{
        const params = {
          start_date: this.dateRange.startDate,
          end_date: this.dateRange.endDate,
        }

        this.appointmentsBetweenDates = await this.$store.dispatch( "appointments_fetchBetweenDates", params );
      }catch ( e ) {

      }
    },


    async onCustomDateRangeChoice() {

      try {

        const params = {
          start_date: this.dateRange.startDate,
          end_date: this.dateRange.endDate,
        }

        this.appointmentsBetweenDates = await this.$store.dispatch( "appointments_fetchBetweenDates", params );

        this.customDateRangeLabel = `Appointments between ${ params.start_date } and ${ params.end_date }`;

        this.modalCustomDateRange.visible = false;
      } catch ( e ) {

      }

    },

    async __fetchAppointments() {
      const today = moment().format( "YYYY-MM-DD" );
      const paramsPending = {
        date: today,
        status: this.statuses.pending
      };

      const paramsCompleted = {
        date: today,
        status: this.statuses.completed
      };

      const paramsCancelled = {
        date: today,
        status: this.statuses.cancelled
      };

      const paramsMissed = {
        date: today,
        status: this.statuses.missed
      };

      this.todayPendingAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsPending );
      this.todayCompletedAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsCompleted );
      this.todayCancelledAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsCancelled );
      this.todayMissedAppointments = await this.$store.dispatch( "appointments_fetchByDate", paramsMissed );
    }

  },

}
</script>

<style scoped>

</style>
