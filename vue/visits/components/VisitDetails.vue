<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Visit Details
        <div class="float-right">
          <button class="btn btn-tiny btn-primary">Edit</button>
        </div>
      </div>
      <div class="card-body">

        <div class="row">
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

  </div><!-- template -->

</template>

<script>
export default {
  name: "VisitDetails",

  data() {
    return {
      //
    }
  },

  computed: {
    visit: function () {
      return this.$store.getters.getVisit;
    }
  },

  mounted() {
    //
  },

  methods: {
    //
  },
}
</script>

<style scoped>

</style>
