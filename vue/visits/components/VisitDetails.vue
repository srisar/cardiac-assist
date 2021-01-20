<template>

  <div>

    <div class="card shadow shadow-sm" v-if="patient">
      <div class="card-header">

        <div class="float-left">
          <a :href="createPatientPageLink()" class="btn btn-tiny btn-secondary">Back to patient</a>
        </div>

        Visit Details
        <div class="float-right">
          <button class="btn btn-tiny btn-primary" @click="onShowEditVisit">Edit</button>
        </div>
      </div>
      <div class="card-body">


        <div class="form-row mb-2" v-if="patient">
          <div class="col">

            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <div class="input-group-text">Patient</div>
              </div>
              <input type="text" class="form-control bg-white" :value="patient.first_name + ' ' + patient.last_name" readonly>
            </div>

          </div><!-- col -->

          <div class="col">

            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <div class="input-group-text">Age</div>
              </div>
              <input type="text" class="form-control bg-white" :value="patient.age" readonly>
            </div>

          </div><!-- col -->

          <div class="col">

            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <div class="input-group-text">Gender</div>
              </div>
              <input type="text" class="form-control bg-white" :value="patient.gender" readonly>
            </div>

          </div><!-- col -->


        </div><!-- row -->

        <!-- --- -->

        <div class="form-row mb-2" v-if="visit">
          <div class="col-md-2">

            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <div class="input-group-text">Date</div>
              </div>
              <input type="text" class="form-control bg-white" :value="visit.visit_date" readonly>
            </div>

          </div><!-- col -->

          <div class="col-md-10">

            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <div class="input-group-text">Remarks</div>
              </div>
              <input type="text" class="form-control bg-white" :value="visit.remarks" readonly>
            </div>

          </div><!-- col -->

        </div><!-- row -->


      </div>
    </div>

    <ModalWindow :visible="modalEditVisitVisible" @close="onHideEditVisit">
      <template v-slot:title>Edit visit details</template>
      <slot>

        <div class="form-row">
          <div class="col-auto">

            <div class="form-group">
              <label>Date</label>
              <DateField v-model="visit.visit_date"/>
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
    </ModalWindow>

  </div><!-- template -->

</template>

<script>
import ModalWindow from "../../_common/components/ModalWindow";
import DateField from "../../_common/components/DateField";

export default {
  name: "VisitDetails",
  components: {ModalWindow, DateField},

  data() {
    return {

      modalEditVisitVisible: false,

    }
  },

  computed: {
    visit: function () {
      return this.$store.getters.getVisit;
    },

    patient: function () {
      return this.visit.patient;
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

      this.$store.dispatch('updateVisit', this.visit)
          .then(r => {

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
