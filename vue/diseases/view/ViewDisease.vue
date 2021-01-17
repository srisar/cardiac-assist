<template>

  <div>

    <div class="container">

      <div class="row">

        <div class="col-12">
          <EditDisease/>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>


import EditDisease from "./components/EditDisease";

export default {
  name: "ViewDisease",
  components: {EditDisease,},

  /*
  *
  * DATA
  * */
  data() {
    return {

      diseaseId: document.getElementById('php_diseases_id').value,

    }
  },


  /*
  *
  * COMPUTED
  * */
  computed: {
    //
  },

  /*
  *
  * MOUNTED
  * */
  mounted() {

    this.$store.dispatch('fetchDisease', this.diseaseId)
        .catch(e => {
          console.log("Failed to fetch disease");
          console.log(e);
        });

  },

  /*
  *
  * METHODS
  * */
  methods: {
    //
  },
}
</script>

<style scoped>

</style>
