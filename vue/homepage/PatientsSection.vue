<template>

  <div>

    <div class="container my-5">
      <div class="row mb-3">
        <div class="col">
          <h3 class="text-center text-uppercase">Patients</h3>
        </div>
      </div>


      <div class="row justify-content-center">
        <div class="col-6">

          <div class="card shadow shadow-sm">

            <div class="card-body">

              <div class="row justify-content-center">

                <div class="col text-center">

                  <h5>Total</h5>
                  <div>
                    <img src="assets/images/icon-patients.svg" class="icon" alt="All patients">
                  </div>
                  <h3 class="m-0">{{ patientsStats.total }}</h3>

                </div>

                <div class="col text-center">

                  <h5>Males</h5>
                  <div>
                    <img src="assets/images/icon-male.svg" class="icon" alt="Male patients">
                  </div>
                  <h3 class="m-0">{{ patientsStats.male }}</h3>

                </div>
                <div class="col text-center">

                  <h5>Females</h5>
                  <div>
                    <img src="assets/images/icon-female.svg" class="icon" alt="Female patients">
                  </div>
                  <h3 class="m-0">{{ patientsStats.female }}</h3>

                </div>
              </div><!-- row -->

              <div class="row mt-2">
                <div class="col text-center">
                  <a href="app/patients/add.php" class="btn btn-success btn-sm">Add new patient</a>
                </div>
              </div>


            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

</template>

<script>
export default {
  name: "PatientsSection",

  data() {
    return {
      //
    }
  },

  computed: {
    patientsStats() {
      return this.$store.getters.getPatientsStats;
    }
  },

  async mounted() {

    try {
      await this.$store.dispatch("patients_getStats");
    } catch (e) {

    }

  },

}
</script>

<style scoped>

.icon {
  width: 64px;
}

</style>
