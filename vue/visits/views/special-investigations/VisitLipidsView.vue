<template>

  <div>

    <div class="row">
      <div class="col">

        <div id="section-visit-ecg" class="my-2">
          <div class="card shadow shadow-sm">

            <div class="card-header">
              Lipids
            </div>

            <div class="card-body">
              <VisitLipids/>
            </div>
          </div><!-- card -->
        </div><!-- visit ecg -->

      </div>
    </div>

  </div><!-- template -->

</template>

<script>
import VisitLipids from "../../components/special_investigations/VisitLipids";

export default {
  name: "VisitLipidsView",
  components: {VisitLipids}
}
</script>

<style scoped>

</style>
