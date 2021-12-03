<template>
  <div>

    <div class="container-fluid">

      <div class="form-row">

        <div class="col-4">
          <ListDiseases/>
        </div>

        <div class="col-8">
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
