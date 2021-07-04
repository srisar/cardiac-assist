<template>

  <div>

    <div class="card shadow shadow-sm mb-3">

      <div class="card-header">Add a new prescription</div>
      <div class="card-body">

        <div class="form-row">
          <div class="col-4">

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Date</span>
              </div>
              <DateField v-model="prescriptionToAdd.date"/>
            </div>

          </div>
        </div>

        <div class="form-group">
          <textarea rows="2" class="form-control" v-model="prescriptionToAdd.remarks" placeholder="Add a remark about the prescription..."></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAddNewPrescription()">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Add
          </button>
        </div>

      </div>
    </div><!-- card -->


    <div class="card shadow shadow-sm mb-3">

      <div class="card-header">
        List of prescriptions
      </div><!-- card-header -->

      <div class="card-body">


        <!-- list of prescriptions -->
        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 100px">Date</th>
            <th>Remarks</th>
          </tr>
          </thead>
          <tbody>

          <tr v-for="item in prescriptionsList" :key="item.id">
            <td>
              <router-link :to="generateEditPrescriptionLink(item)">{{ item.date }}</router-link>
            </td>
            <td>{{ item.remarks }}</td>
          </tr>

          </tbody>
        </table>


      </div><!-- card-body -->
    </div><!-- card -->

    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>

  </div><!-- template -->

</template>

<script>
import ModalWindow from "../../../../_common/components/ModalWindow";
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";
import DateField from "../../../../_common/components/DateField";

export default {
  name: "PrescriptionView",
  components: {DateField, ModalWindow},
  data() {
    return {

      isAddPrescriptionModalVisible: false,
      /*
      * add prescription window
      * */
      prescriptionToAdd: {
        remarks: "",
        date: moment().format("YYYY-MM-DD"),
      },


      selectedPrescription: {},


    }
  },

  computed: {

    prescriptionsList() {
      return this.$store.getters.getVisitPrescriptions;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },
  },

  async mounted() {


    try {

      await this.$store.dispatch("prescriptions_fetchAll", this.visitId);

    } catch (e) {
      alert("Failed to fetch prescriptions");
    }

  },

  methods: {

    /*
    * Generate edit prescription link
    * */
    generateEditPrescriptionLink(prescription) {
      return `/prescriptions/edit/${prescription.id}`;
    },


    /*
    * On add new prescription
    * */
    async onAddNewPrescription() {

      try {

        const params = {
          visit_id: this.visitId,
          date: this.prescriptionToAdd.date,
          remarks: this.prescriptionToAdd.remarks,
        };

        await this.$store.dispatch("prescription_add", params);
        await this.$store.dispatch("prescriptions_fetchAll", this.visitId);

      } catch (e) {
        errorMessageBox("Failed to add new prescription");
      }

    }


  },
}
</script>

<style scoped>

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

</style>
