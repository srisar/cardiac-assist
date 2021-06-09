<template>

  <div>

    <div class="row">
      <div class="col">

        <div class="card shadow-sm shadow">

          <div class="card-header">Other remarks</div>

          <div class="card-body">

            <div class="row justify-content-center">
              <div class="col">

                <div class="form-group">
                  <RichEditorV2 v-model="otherRemarks"/>
                </div>

              </div>
            </div>


            <div class="row">
              <div class="col">

                <div class="text-center">
                  <button class="btn btn-success" @click="onUpdate()">Update</button>
                </div>

              </div>
            </div>

          </div>

        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->


  </div>

</template>

<script>
import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "OtherRemarksView",
  components: {RichEditorV2},

  data() {
    return {

      otherRemarks: ""

    }
  },

  computed: {
    visitId() {
      return this.$store.getters.getVisitId;
    },

    visit() {
      return this.$store.getters.getVisit;
    }
  },

  watch: {
    visit() {
      this.otherRemarks = this.visit.other_remarks || "";
    }
  },

  created() {

    this.otherRemarks = this.visit.other_remarks || "";

  },

  methods: {

    async onUpdate() {

      try {

        const params = {
          id: this.visitId,
          other_remarks: this.otherRemarks,
        };

        await $.post(`${getSiteURL()}/api/update/visit/visit-other-remarks.php`, params);

        await this.$store.dispatch("fetchVisit", this.visitId);

        successMessageBox("Review date updated");

      } catch (e) {
        errorMessageBox("Failed to update");
      }

    }

  },

}
</script>

<style scoped>

</style>
