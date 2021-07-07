<template>

  <div class="">

    <table class="table table-sm table-bordered">
      <thead>
      <tr :class="tableClass">
        <th style="width: 220px">Patient</th>
        <th class="text-center" style="width: 30px">Gender</th>
        <th class="text-center" style="width: 135px">DoB/Age</th>
        <th>Remarks</th>
        <th class="text-center" style="width: 110px">Date</th>
        <th class="text-center" style="width: 10px">Status</th>
        <th style="width: 10px"></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in appointments">
        <td>
          <a :href="renderPatientUrl(item.patient.id)">
            {{ item.patient.first_name }} {{ item.patient.last_name }}
          </a>
        </td>
        <td class="text-center">{{ item.patient.gender | gender }}</td>
        <td class="text-center">{{ item.patient.dob }} ({{ calculateAge( item.patient.dob ) }})</td>
        <td>{{ item.remarks }}</td>
        <td class="text-center">{{ item.date }}</td>
        <td class="text-center">
          <img :src="getStatusIcon(item.status)" class="icon-16" alt="">
        </td>
        <td>
          <button class="btn btn-tiny btn-outline-dark" @click="onShowSelectedAppointment(item)">
            <img src="/assets/images/actions/edit.svg" class="icon-16" alt="">
          </button>
        </td>
      </tr>
      </tbody>
    </table>

    <ModalWindow :visible="modalAppointment.visible" @close="modalAppointment.visible = false">
      <template v-slot:title>Edit Appointment</template>
      <slot>

        <div class="form-row justify-content-center">
          <div class="col-4">
            <div class="form-group">
              <label>Date</label>
              <DateField v-model="selectedAppointment.date"/>
            </div>
          </div>

          <div class="col-4">
            <div class="form-group">
              <label>Status</label>
              <input type="text" class="form-control" disabled :value="selectedAppointment.status">
            </div>
          </div>

        </div>

        <div class="form-row">
          <div class="col">

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model.trim="selectedAppointment.remarks"></textarea>
            </div>

          </div>
        </div>

        <div class="text-center">
          <button class="btn btn-success">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
          </button>
          <hr>

          <div class="">
            <button class="btn btn-sm btn-success" @click="onSetStatus(statuses.completed)">Set as completed</button>
            <button class="btn btn-sm btn-info" @click="onSetStatus(statuses.cancelled)">Set as cancelled</button>
            <button class="btn btn-sm btn-danger" @click="onSetStatus(statuses.missed)">Set as missed</button>
            <button class="btn btn-sm btn-warning" @click="onSetStatus(statuses.pending)">Set as pending</button>
          </div>

        </div>


      </slot>
    </ModalWindow>

  </div>


</template>

<script>
import ModalWindow from "../../_common/components/ModalWindow";
import DateField from "../../_common/components/DateField";

export default {
  name: "AppointmentsTable",
  components: { DateField, ModalWindow },
  props: ["appointments", "tableClass"],

  data() {
    return {
      modalAppointment: {
        visible: false,
      },

      selectedAppointment: {
        id: null,
        patient_id: null,
        date: "",
        remarks: "",
        status: ""
      },
    }
  },


  computed: {
    statuses() {
      return this.$store.getters.getAppointmentStatuses;
    }
  },

  filters: {
    gender( value ) {
      if ( value === "MALE" ) return "M";
      if ( value === "FEMALE" ) return "F";
      if ( value === "OTHER" ) return "O";
      return value;
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

    onShowSelectedAppointment( appointment ) {
      this.selectedAppointment = appointment;
      this.modalAppointment.visible = true;
    },

    /* ------------------------------------------- */

    async onSetStatus( status ) {
      try {
        const params = {
          id: this.selectedAppointment.id,
          status: status
        };

        await this.$store.dispatch( "appointments_setStatus", params );

        this.modalAppointment.visible = false;
        this.$emit( "status-updated" );
      } catch ( e ) {

      }
    },

    getStatusIcon( status ) {
      if ( status === this.statuses.completed ) {
        return "/assets/images/actions/done.svg";
      } else if ( status === this.statuses.pending ) {
        return "/assets/images/actions/in-progress.svg";
      } else if ( status === this.statuses.missed ) {
        return "/assets/images/actions/warning.svg";
      } else if ( status === this.statuses.cancelled ) {
        return "/assets/images/actions/question.svg";
      }
    },


  },

}
</script>

<style scoped>

</style>
