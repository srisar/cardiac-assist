<template>

  <div>

    <div class="row">
      <div class="col">

        <div class="card shadow-sm shadow">

          <div class="card-header">Review On</div>

          <div class="card-body">

            <div class="row justify-content-center">
              <div class="col-4">

                <div class="mb-3">
                  <DateField class="text-center" v-model="reviewInDate"/>
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

  </div><!-- template -->

</template>

<script>
import DateField from "../../../_common/components/DateField";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "VisitReviewInView",
  components: {DateField},

  data() {
    return {

      reviewInDate: moment().format("YYYY-MM-DD"),

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
      this.reviewInDate = this.visit.review_in;
    }
  },

  mounted() {

    this.reviewInDate = this.visit.review_in;
  },

  methods: {

    async onUpdate() {

      try {

        const params = {
          id: this.visitId,
          review_in: this.reviewInDate,
        };

        await $.post(`${getSiteURL()}/api/update/visit/visit-review-date.php`, params);
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
