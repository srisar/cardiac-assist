<template>

  <div>

    <div class="card">
      <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

          <div>
            <div class="flex-fill">Special Investigations</div>
          </div><!-- left -->

          <!-- checkboxes for investigation items -->
          <div class="">

            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" id="check-ecg" v-model="visitECGExpanded">
              <label for="check-ecg" class="form-check-label">ECG</label>
            </div>

            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" id="check-lipids" v-model="visitLipidsExpanded">
              <label for="check-lipids" class="form-check-label">Lipids</label>
            </div>

          </div><!-- right -->


        </div>

      </div>

      <div class="card-body bg-dark">

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

        <!-- section: visit ecg -->
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
        </div><!-- visit ecg -->


      </div><!-- card-body -->
    </div><!-- card -->

  </div><!-- template -->

</template>

<script>
import VisitECG from "./special_investigations/VisitECG";
import VisitLipids from "./special_investigations/VisitLipids";

export default {
  name: "SpecialInvestigations",
  components: {VisitLipids, VisitECG},
  data() {
    return {

      visitECGExpanded: false,
      visitLipidsExpanded: true,

    }
  },

  computed: {},

  methods: {
    //
    iconToggle: function (value) {
      if (value) return 'bi-arrow-up';
      else return 'bi-arrow-down';
    },

  },
}
</script>

<style scoped>

</style>
