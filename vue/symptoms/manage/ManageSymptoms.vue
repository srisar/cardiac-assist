<template>

  <div class="container-fluid">

    <div class="form-row">

      <div class="col-4">
        <ListSymptoms/>

      </div>

      <div class="col-8">
        <router-view></router-view>
      </div><!-- col -->


    </div><!-- row -->

  </div><!-- container -->

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
