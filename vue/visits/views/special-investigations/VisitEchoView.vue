<template>

  <div>

    <div class="row">
      <div class="col">
        <h3 class="text-center">Special Investigations</h3>
      </div>
    </div>

    <div class="row">
      <div class="col">

        <div id="section-visit-ecg">
          <div class="card shadow shadow-sm">

            <div class="card-header">
              Echocardiography
            </div>

            <div class="card-body">
              <VisitEcho/>
            </div>
          </div><!-- card -->
        </div><!-- visit ecg -->

      </div>
    </div>

  </div><!-- template -->

</template>

<script>
import VisitEcho from "../../components/special_investigations/VisitEcho";

export default {
  name: "VisitEchoView",
  components: {VisitEcho}
}
</script>

<style scoped>

</style>
