<template>

  <div>

    <div class="pt-2">


      <div class="container pb-5">

        <div class="row">
          <div class="col">
            <h3 class="text-center">Basic Details</h3>
          </div>
        </div>


        <div class="row">
          <div class="col">
            <VisitDetails/>
          </div><!-- col -->
        </div><!-- row -->
      </div>

    </div><!-- Visit details section -->


  </div><!-- template -->

</template>

<script>

import VisitDetails from "./components/VisitDetails";

export default {
  name: "BasicView",
  components: {
    VisitDetails,
  },

  /*
  * === DATA ===
  * */
  data() {
    return {}
  },

  /*
  * === COMPUTED ===
  * */
  computed: {},


  created() {

    // $.get(`${getSiteURL()}/api/get/visit/visit-exist.php`, {id: this.visitId})
    //     .done(response => {
    //       if (response.data === false) redirect(`${getSiteURL()}/app/patients/list.php`)
    //     })
    //     .fail(error => {
    //       redirect(`${getSiteURL()}/app/patients/list.php`)
    //     })
  },

  /*
  * === MOUNTED ===
  * */
  mounted() {


  },
  /* *** MOUNTED *** */

}
</script>

<style scoped>

.bg-diagnosis {
  background-color: #FEF5E6;
}

.bg-special-investigations {
  background-color: #EEE1FE;
}

</style>
