<template>
  <div>

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-md-4">
          <ListDiseases/>
        </div>

        <div class="col-12 col-md-8 mb-2">
          <SaveDisease v-if="panelMode === 'ADD'"/>
          <EditDisease v-if="panelMode === 'EDIT'"/>
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->
</template>

<script>

import Vue from "vue";
import store from "./store";
import SaveDisease from "./components/SaveDisease";
import EditDisease from "./components/EditDisease";
import ListDiseases from "./components/ListDiseases";

export default {
  name: "ManageDiseases",
  components: {SaveDisease, ListDiseases, EditDisease,},
  store: store,
  props: [],

  data() {
    return {
      //
    }
  },

  computed: {
    panelMode: function () {
      return this.$store.getters.getPanelMode;
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
