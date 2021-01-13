<template>

  <div>

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-md-4">
          <ListSymptoms/>

        </div>

        <div class="col-12 col-md-8 mb-2">
          <SaveSymptom v-if="panelMode === 'ADD'"/>
          <EditSymptom v-if="panelMode === 'EDIT'"/>
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

import SaveSymptom from "./components/SaveSymptom";
import EditSymptom from "./components/EditSymptom";
import ListSymptoms from "./components/ListSymptoms";

import store from './store'
import Vue from "vue";

export default {
  name: "ManageSymptoms",
  components: {SaveSymptom, ListSymptoms, EditSymptom,},
  store: store,

  data() {
    return {}
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
