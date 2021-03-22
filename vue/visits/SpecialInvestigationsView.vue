<template>

  <div>

    <div class="container">
      <div class="row">
        <div class="col">

          <!-- section: visit ecg -->
          <div id="section-visit-ecg" class="my-2">
            <div class="card shadow shadow-sm">

              <div class="card-header" @click.stop="visitECGExpanded = !visitECGExpanded">
                <div class="d-flex">
                  <span><i class="bi" :class="iconToggle(visitECGExpanded)"></i></span>
                  <div>Electrocardiogram (ECG)</div>
                </div>
              </div>

              <div class="card-body" v-if="visitECGExpanded">
                <VisitECG/>
              </div>
            </div><!-- card -->
          </div><!-- visit ecg -->


          <!-- section: visit lipids -->
          <div id="section-visit-lipids" class="my-2">
            <div class="card shadow shadow-sm">

              <div class="card-header" @click="visitLipidsExpanded = !visitLipidsExpanded">
                <div class="d-flex">
                  <span><i class="bi" :class="iconToggle(visitLipidsExpanded)"></i></span>
                  <div>Lipid Profiles</div>
                </div>
              </div>

              <div class="card-body" v-if="visitLipidsExpanded">
                <VisitLipids/>
              </div>
            </div><!-- card -->
          </div><!-- visit lipids -->


          <!-- section: visit coronary ct -->
          <div id="section-visit-coronary-ct" class="my-2">
            <div class="card shadow shadow-sm">

              <div class="card-header" @click="visitCoronaryCTExpanded = !visitCoronaryCTExpanded">
                <div class="d-flex">
                  <span><i class="bi" :class="iconToggle(visitCoronaryCTExpanded)"></i></span>
                  <div>Coronary CT</div>
                </div>
              </div>

              <div class="card-body" v-if="visitCoronaryCTExpanded">
                <VisitCoronaryCT/>
              </div>
            </div><!-- card -->
          </div><!-- visit coronary ct -->


          <!-- section: visit coronary ct -->
          <div id="section-visit-echocardiography" class="my-2">
            <div class="card shadow shadow-sm">

              <div class="card-header" @click="visitEchoExpanded = !visitEchoExpanded">
                <div class="d-flex">
                  <span><i class="bi" :class="iconToggle(visitEchoExpanded)"></i></span>
                  <div>Echocardiography</div>
                </div>
              </div>

              <div class="card-body" v-if="visitEchoExpanded">
                <VisitEcho/>
              </div>
            </div><!-- card -->
          </div><!-- visit coronary ct -->


        </div><!-- col -->
      </div><!-- row -->
    </div><!-- container -->


  </div>

</template>

<script>

import VisitECG from "./components/special_investigations/VisitECG"
import VisitLipids from "./components/special_investigations/VisitLipids"
import VisitCoronaryCT from "./components/special_investigations/VisitCoronaryCT"
import VisitEcho from "./components/special_investigations/VisitEcho"

export default {
  name: "SpecialInvestigationsView",
  components: {VisitEcho, VisitCoronaryCT, VisitECG, VisitLipids},
  data() {
    return {
      visitECGExpanded: true,
      visitLipidsExpanded: true,
      visitCoronaryCTExpanded: true,
      visitEchoExpanded: true,
    }
  },

  computed: {
    visitId: function () {
      return this.$store.getters.getVisitId
    },
  },

  methods: {

    iconToggle: function (value) {
      if (value) return 'bi-arrow-bar-up';
      else return 'bi-arrow-bar-down';
    },

  },
}
</script>

<style scoped>

.card-header {
  cursor: pointer;
}

</style>
