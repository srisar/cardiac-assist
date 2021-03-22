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


}
</script>

<style scoped>
</style>
