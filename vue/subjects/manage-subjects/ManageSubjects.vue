<template>

  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-12 col-md-4">
        <AddSubject :event-bus="eventBus"></AddSubject>
      </div><!--col-->
    </div><!--row-->

    <div class="row justify-content-center">
      <div class="col col-md-4">
        <ListSubjects :event-bus="eventBus"></ListSubjects>
      </div>
    </div><!-- row -->

  </div>

</template>

<script>
import ListSubjects from "./ListSubjects";
import AddSubject from "./AddSubject";
import Vue from "vue";

export default {
  name: "ManageSubjects",
  components: {ListSubjects, AddSubject},
  data: function () {
    return {
      eventBus: new Vue({}),
    };
  },
  computed: {
    //
  },
  mounted() {
    //
  },
  methods: {
    //
  }
}
</script>

<style scoped>

</style>
