<template>
  <div>

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-md-4">
          <ListInvestigations/>
        </div>

        <div class="col-12 col-md-8 mb-2">
          <SaveInvestigation v-if="panelMode === 'ADD'"/>
          <EditInvestigation v-if="panelMode === 'EDIT'"/>
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->
</template>

<script>

import SaveInvestigation from "./components/SaveInvestigation";
import ListInvestigations from "./components/ListInvestigations";
import EditInvestigation from "./components/EditInvestigation";

export default {
  name: "ManageInvestigations",
  components: {SaveInvestigation, ListInvestigations, EditInvestigation},
  props: [],

  data() {
    return {
      //
    }
  },

  computed: {
    panelMode: function () {
      return this.$store.state.panelMode;
    }
  },

  mounted() {
    //
  },

  methods: {
    //
  },

}
</script>

<style scoped>

</style>
