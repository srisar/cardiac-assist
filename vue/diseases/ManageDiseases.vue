<template>
  <div>

    <div class="container-fluid">

      <div class="row">
        <div class="col-12 col-md-8 mb-2">
          <SaveDisease :event-bus="eventBus"/>
        </div><!-- col -->

        <div class="col-12 col-md-4">
          <ListDiseases ref="listDiseases" :event-bus="eventBus"/>
        </div>
      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->
</template>

<script>

import Vue from "vue";
import SaveDisease from "./SaveDisease";
import ListDiseases from "./ListDiseases";

export default {
  name: "ManageDiseases",
  components: {SaveDisease, ListDiseases},
  props:[],

  data() {
    return {
      //


      eventBus: new Vue({}),
    }
  },

  computed: {
    //
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
