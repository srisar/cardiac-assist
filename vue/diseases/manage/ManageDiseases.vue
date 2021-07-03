<template>
  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-4">
          <ListDiseases class="sticky-top" style="top: 20px"/>
        </div>

        <div class="col-12 col-md-8 mb-2">
          <router-view></router-view>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->
</template>

<script>

import ListDiseases from "./components/ListDiseases";

export default {
  name: "ManageDiseases",
  components: { ListDiseases },
}
</script>

<style scoped>

</style>
