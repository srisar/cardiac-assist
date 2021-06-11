<template>

  <div>

    <div class="row">
      <div class="col">

        <div class="card shadow-sm shadow">

          <div class="card-header">Review In</div>

          <div class="card-body">

            <div class="row" v-if="! hasReviewInDate">
              <div class="col">
                <p>No review in date period provided. Choose one period from the list below or directly set the date for review.</p>
              </div>
            </div>

            <div class="row justify-content-center mb-3">
              <div class="col-6">

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Periods</span>
                  </div>
                  <select class="custom-select" v-model="reviewPeriod" @change="onUpdatePeriod()">
                    <option value="0" disabled>CHOOSE ONE</option>
                    <option value="1w">1 Week</option>
                    <option value="2w">2 Weeks</option>
                    <option value="1m">1 Month</option>
                    <option value="2m">2 Months</option>
                    <option value="4m">4 Months</option>
                    <option value="6m">6 Months</option>
                    <option value="1y">1 Year</option>
                    <option value="2y">2 Years</option>
                    <option value="5y">5 Years</option>
                  </select>
                </div>

              </div>
            </div>

            <div class="row justify-content-center" v-if="showReviewDateField">
              <div class="col-4">
                <div class="mb-3 text-center">
                  <label>Review in</label>
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

      reviewPeriod: "0",

      reviewInDate: moment().format("YYYY-MM-DD"),

    };
  },


  computed: {
    visitId() {
      return this.$store.getters.getVisitId;
    },

    visit() {
      return this.$store.getters.getVisit;
    },

    hasReviewInDate() {
      console.log("visit review date", this.visit.review_in);
      return !_.isNull(this.visit.review_in) || _.isUndefined(this.visit.review_in);
    },

    showReviewDateField() {
      return this.hasReviewInDate || this.reviewPeriod !== "0";
    }

  },


  watch: {
    visit() {
      if (!_.isUndefined(this.visit.review_in)) {
        this.reviewInDate = this.visit.review_in;
      }
    }
  },


  mounted() {


    if (!_.isUndefined(this.visit.review_in)) {
      this.reviewInDate = this.visit.review_in;
    }

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

    },

    onUpdatePeriod() {

      let today = moment();
      let newReviewDate = moment();

      if (this.reviewPeriod === "1w") {
        newReviewDate = today.add(1, "week");
      } else if (this.reviewPeriod === "2w") {
        newReviewDate = today.add(2, "week");
      } else if (this.reviewPeriod === "1m") {
        newReviewDate = today.add(1, "month");
      } else if (this.reviewPeriod === "2m") {
        newReviewDate = today.add(2, "month");
      } else if (this.reviewPeriod === "4m") {
        newReviewDate = today.add(4, "month");
      } else if (this.reviewPeriod === "6m") {
        newReviewDate = today.add(6, "month");
      } else if (this.reviewPeriod === "1y") {
        newReviewDate = today.add(1, "year");
      } else if (this.reviewPeriod === "2y") {
        newReviewDate = today.add(2, "year");
      } else if (this.reviewPeriod === "5y") {
        newReviewDate = today.add(5, "year");
      }

      this.reviewInDate = newReviewDate.format("YYYY-MM-DD");

    }

  },

}
</script>

<style scoped>

</style>
