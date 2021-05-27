<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div>Prescriptions</div>
        <div>
          <button class="btn btn-tiny btn-success" @click="isAddModalVisible=true">Add</button>
        </div>
      </div><!-- card-header -->

      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th>Remarks</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>

          <tr v-for="item in prescrptionsList" :key="item.id">
            <td>{{ item.remarks }}</td>
            <td></td>
          </tr>

          </tbody>
        </table>

      </div><!-- card-body -->

    </div><!-- card -->


    <ModalWindow :visible="isAddModalVisible" @close="onCloseAddModal()">
      <template v-slot:title>Add a prescription</template>

      <slot>

        <div class="form-group">
          <label for="text-remarks" class="form-label">Remarks</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model="prescription.remarks"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success">Add</button>
        </div>

      </slot>

    </ModalWindow>

  </div><!-- template -->

</template>

<script>
import ModalWindow from "../../../_common/components/ModalWindow";

export default {
  name: "Prescriptions",
  components: {ModalWindow},
  data() {
    return {

      isAddModalVisible: false,

      prescription: {
        remarks: ""
      }

    }
  },

  computed: {

    prescrptionsList() { return this.$store.getters.getVisitPrescriptions; }

  },

  async mounted() {


    try {

      const visit_id = this.$store.getters.getVisitId;

      await this.$store.dispatch("prescriptions_fetchAll", visit_id);

    } catch (e) {
      alert("Failed to fetch prescriptions");
    }

  },

  methods: {

    onCloseAddModal() {
      this.isAddModalVisible = false;
    }

  },

}
</script>

<style scoped>

</style>
