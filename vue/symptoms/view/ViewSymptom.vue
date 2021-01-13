<template>

  <div>

    <div class="container">

      <div class="row">

        <div class="col-12">
          <EditSymptom/>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

import EditSymptom from "./components/EditSymptom";

import store from './store'

export default {
  name: "ViewSymptom",
  components: {EditSymptom,},
  store: store,

  data() {
    return {

      symptomId: document.getElementById('php_symptom_id').value,

    }
  },

  computed: {

  },

  mounted() {

    this.$store.dispatch('fetchSymptom', this.symptomId)
        .then(r => {

        })
        .catch(e => {

        });

  },

  methods: {
    //
  },
}
</script>

<style scoped>

</style>
