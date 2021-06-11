<template>

  <div>

    <div class="container mt-3">


      <div class="row justify-content-center">
        <div class="col-12 col-lg-6">

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

              <div class="row my-3">
                <div class="col text-center">
                  <a href="app/patients/add.php" class="btn btn-success btn-sm">Add new patient</a>
                  <a href="app/patients/list.php" class="btn btn-primary btn-sm">View all patients</a>
                </div>
              </div>

              <div class="row my-3">

                <div class="col">
                  <div class="input-group">
                    <input type="text" class="form-control"
                           v-model.trim="patients.search.query"
                           @keyup.enter="onSearch()"
                           placeholder="Search for names, addresses and phones">
                    <div class="input-group-append">
                      <button class="btn btn-primary" @click="onSearch()">Search</button>
                    </div>
                  </div>
                </div>

              </div><!-- row -->


            </div>
          </div>

        </div>
      </div>

    </div>

  </div>

</template>

<script>

let _ = require("lodash");

export default {
  name: "PatientsSection",

  data() {
    return {

      patients: {
        search: {
          query: "",
        }
      }

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

  methods: {

    onSearch() {

      if (!_.isEmpty(this.patients.search.query)) {
        window.location.href = `${getSiteURL()}/app/patients/list.php#search/${this.patients.search.query}`;
      }

    },

  },

}
</script>

<style scoped>

.icon {
  width: 48px;
}

</style>
