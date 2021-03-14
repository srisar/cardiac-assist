<template>

  <div>

    <div class="section">
      <h2 class="section__title">Special Investigations</h2>
    </div>

    <!-- section: visit ecg -->
    <div id="section-visit-ecg" class="my-2">
      <div class="card shadow shadow-sm">

        <div class="card-header">
          <div class="d-flex">
            <button class="btn btn-tiny btn-warning mr-2" @click="visitECGExpanded = !visitECGExpanded">
              <i class="bi" :class="iconToggle(visitECGExpanded)"></i>
            </button>
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

        <div class="card-header">
          <div class="d-flex">
            <button class="btn btn-tiny btn-warning mr-2" @click="visitLipidsExpanded = !visitLipidsExpanded">
              <i class="bi" :class="iconToggle(visitLipidsExpanded)"></i>
            </button>
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

        <div class="card-header">
          <div class="d-flex">
            <button class="btn btn-tiny btn-warning mr-2" @click="visitCoronaryCTExpanded = !visitCoronaryCTExpanded">
              <i class="bi" :class="iconToggle(visitCoronaryCTExpanded)"></i>
            </button>
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

        <div class="card-header">
          <div class="d-flex">
            <button class="btn btn-tiny btn-warning mr-2" @click="visitEchoExpanded = !visitEchoExpanded">
              <i class="bi" :class="iconToggle(visitEchoExpanded)"></i>
            </button>
            <div>Echocardiography</div>
          </div>
        </div>

        <div class="card-body" v-if="visitEchoExpanded">
          <VisitEchocardiography/>
        </div>
      </div><!-- card -->
    </div><!-- visit coronary ct -->

  </div><!-- template -->

</template>

<script>
import VisitECG from "./special_investigations/VisitECG";
import VisitLipids from "./special_investigations/VisitLipids";
import VisitCoronaryCT from "./special_investigations/VisitCoronaryCT";
import VisitEchocardiography from "./special_investigations/VisitEcho";

export default {
  name: "SpecialInvestigations",

  components: { VisitEchocardiography, VisitCoronaryCT, VisitLipids, VisitECG },

  data() {
    return {
      visitLipidsExpanded    : false,
      visitECGExpanded       : false,
      visitCoronaryCTExpanded: false,
      visitEchoExpanded      : false,
    }
  },

  computed: {},

  methods: {
    //
    iconToggle: function (value) {
      if ( value ) return 'bi-arrow-up';
      else return 'bi-arrow-down';
    },

  },
}
</script>

<style scoped>

</style>
