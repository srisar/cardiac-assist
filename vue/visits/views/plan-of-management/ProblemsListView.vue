<template>

  <div>

    <div class="container pb-5">
      <div class="row">
        <div class="col">
          <h3 class="text-center">Problems List</h3>
        </div>
      </div>

      <!-- prescriptions -->
      <div class="row mb-3">
        <div class="col">
          <Prescriptions/>
        </div><!-- col -->
      </div>


    </div>

  </div><!-- template -->

</template>

<script>
import Prescriptions from "../../components/plan-of-management/Prescriptions";

export default {
  name: "ProblemsListView",
  components: {Prescriptions}
}
</script>

<style scoped>

</style>
