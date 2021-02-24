<template>

  <div>

    <div class="card">
      <div class="card-header">

        <div class="d-flex align-items-center justify-content-between">
          <div>Appointments</div>
          <button class="btn btn-tiny btn-primary" @click="onClickShowAddModal">Add an appointment</button>
        </div>

      </div>
      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 100px">Date</th>
            <th>Remarks</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item) in appointmentsList">
            <td><a href="#" @click="onClickSelectAppointment(item)">{{ item.date }}</a></td>
            <td>{{ item.remarks }}</td>
            <td>{{ item.status }}</td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->
    </div><!-- card -->

    <ModalWindow id="modal-add-appointment" :visible="modalAddAppointment.visible" @modal-hiding="onClickHideModal(modalAddAppointment)">
      <template v-slot:title>Add an appointment for {{ fullName }}</template>
      <slot>

        <div class="form-row">
          <div class="col-auto">
            <div class="form-group">
              <label>Date</label>
              <DateField v-model="appointmentToAdd.date"/>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col">
            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" v-model="appointmentToAdd.remarks" rows="5"></textarea>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onClickSave">Save</button>
          </div>
        </div>

      </slot>
    </ModalWindow>
    <!-- add appointment -->

    <ModalWindow id="modal-edit-appointment" :visible="modalEditAppointment.visible" @modal-hiding="onClickHideModal(modalEditAppointment)">
      <template v-slot:title>Edit appointment</template>
      <slot>

        <div class="form-row">

        </div>

        <div class="form-row">
          <div class="col">
            <div class="form-group">
              <label>Date</label>
              <DateField v-model="appointmentToEdit.date"/>
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Status</label>
              <select class="form-control bg-secondary text-white" v-model="appointmentToEdit.status">
                <option v-for="(item, index) in statusList" :value="index">{{ item }}</option>
              </select>
            </div>
          </div>

        </div><!-- row -->

        <div class="form-row">
          <div class="col">
            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" v-model="appointmentToEdit.remarks" rows="5"></textarea>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col">

            <div class="d-flex justify-content-center">
              <button class="btn btn-success mx-1" @click="onClickUpdate">Update</button>
              <button class="btn btn-danger mx-1" @click="onClickDelete">Delete</button>
            </div>

          </div>
        </div>

      </slot>
    </ModalWindow>

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../../_common/components/ModalWindow";
import DateField from "../../../_common/components/DateField";

const _ = require('lodash');

export default {
  name: "ListAppointments",
  components: {ModalWindow, DateField},
  data() {
    return {

      modalAddAppointment: {
        visible: false,
      },
      modalEditAppointment: {
        visible: false,
      },

      appointmentToAdd: {
        patient_id: undefined,
        date: moment().format('YYYY-MM-DD'),
        remarks: "",
      },

      appointmentToEdit: {
        id: undefined,
        patient_id: undefined,
        date: undefined,
        remarks: undefined,
        status: undefined,
      },

      statusList: {
        PENDING: 'Pending',
        COMPLETED: 'Completed',
        CANCELLED: 'Cancelled',
        MISSED: 'Missed',
      }

    }
  },

  computed: {

    appointmentsList: function () {
      return this.$store.getters.getAppointmentsList
    },

    patient: function () {
      return this.$store.getters.getPatient
    },

    fullName: function () {
      return this.patient.first_name + " " + this.patient.last_name
    },

  },

  /*
  * === MOUNTED ===
  * */
  mounted() {

  },

  /*
  * === METHODS ===
  * */
  methods: {

    /*
    * Save a new appointment
    * */
    onClickSave: function () {

      const appointment = {
        patient_id: this.patient.id,
        date: this.appointmentToAdd.date,
        remarks: this.appointmentToAdd.remarks,
      }

      this.$store.dispatch('addAppointment', appointment)
          .then(() => {

            // hide modal
            this.modalAddAppointment.visible = false

            // clear fields
            this.appointmentToAdd.remarks = ""
          })
          .catch(e => {
            console.log(e)
            alert('Failed to add an appointment')
          })

    }, /* on click save */

    onClickUpdate: function () {

      const appointment = {
        id: this.appointmentToEdit.id,
        date: this.appointmentToEdit.date,
        remarks: this.appointmentToEdit.remarks,
        status: this.appointmentToEdit.status,
      }

      this.$store.dispatch('editAppointment', appointment)
          .then(() => {
            this.modalEditAppointment.visible = false
          })
          .catch(e => {
            alert('Failed to update the appointment')
            console.log(e)
          })

    }, /* on click update */

    onClickDelete: function () {

      const id = this.appointmentToEdit.id

      if (confirm('Are you sure to delete?')) {

        this.$store.dispatch('deleteAppointment', id)
            .then(() => {
              this.modalEditAppointment.visible = false
            })
            .catch(e => {
              alert('Failed to delete the appointment')
              console.log(e)
            })
      }

    }, /* on click delete */

    onClickShowAddModal: function () {
      this.appointmentToAdd.patient_id = this.patient.id;
      this.modalAddAppointment.visible = true
    },

    onClickHideModal: function (modal) {
      modal.visible = false
    },

    onClickSelectAppointment: function (appointment) {
      this.appointmentToEdit = appointment
      this.modalEditAppointment.visible = true
    }

  },

}
</script>

<style scoped>

</style>
