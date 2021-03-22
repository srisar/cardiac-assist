<template>

  <div>



  </div><!-- template -->

</template>

<script>
import VisitECG from "./special_investigations/VisitECG";
import VisitLipids from "./special_investigations/VisitLipids";
import VisitCoronaryCT from "./special_investigations/VisitCoronaryCT";
import VisitEchocardiography from "./special_investigations/VisitEcho";

export default {
  name: "SpecialInvestigations",

  components: {VisitEchocardiography, VisitCoronaryCT, VisitLipids, VisitECG},

  data() {
    return {
      visitECGExpanded: false,
      visitLipidsExpanded: true,
      visitCoronaryCTExpanded: false,
      visitEchoExpanded: false,
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
