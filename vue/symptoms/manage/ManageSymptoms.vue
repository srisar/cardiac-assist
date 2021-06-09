<template>

  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-4">
          <ListSymptoms/>

        </div>

        <div class="col-12 col-md-8 mb-2">
          <router-view></router-view>
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

import ListSymptoms from "./components/ListSymptoms";

export default {
  name: "ManageSymptoms",
  components: {ListSymptoms,},


}
</script>

<style scoped>

</style>
