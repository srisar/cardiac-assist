<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div>
          Symptoms
        </div>
        <div>
          <button class="btn btn-success btn-tiny" @click="onClickAddSymptom">Add a new symptom</button>
        </div>
      </div>
      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-striped">
          <thead>
          <tr>
            <th>Symptom</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in symptomsList">
            <td><a href="#" @click="setSelectedSymptom(item)">{{ item.symptom_name }}</a></td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>


export default {
  name      : "ListSymptoms",
  components: {},

  props: [],

  data() {
    return {}
  },

  computed: {

    symptomsList: function () {
      return this.$store.getters.getSymptomsList;
    }

  },

  mounted() {
    //
    this.fetchAll();

  },

  methods: {
    //

    /*
    * Fetch existing symptoms
    * */
    fetchAll: function () {
      this.$store.dispatch('fetchSymptoms');
    },

    setSelectedSymptom: function (symptom) {
      this.$store.dispatch('setSelectedSymptom', symptom);
    },

    onCloseViewSelectedSymptom: function () {
      this.selectedSymptom = null;
    },

    onClickAddSymptom: function () {
      this.$store.commit('setPanelModeAdd');
    }

  },

}
</script>

<style scoped>

</style>
