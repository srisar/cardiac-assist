<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header">
        Diseases
        <div class="float-right">
          <button class="btn btn-success btn-tiny" @click="onClickAdd">Add a new disease</button>
        </div>
      </div>
      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-striped">
          <thead>
          <tr>
            <th>Disease Code</th>
            <th>Disease</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in diseasesList">
            <td>{{ item.disease_code }}</td>
            <td><a href="#" @click="setSelected(item)">{{ item.disease }}</a></td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>


export default {
  name: "ListDiseases",
  components: {},

  props: [],

  data() {
    return {}
  },

  computed: {

    diseasesList: function () {
      return this.$store.getters.getDiseasesList;
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
      this.$store.dispatch('fetchDiseases');
    },

    setSelected: function (disease) {
      this.$store.dispatch('setSelectedDisease', disease);
    },

    onClickAdd: function () {
      this.$store.commit('setPanelModeAdd');
    }

  },

}
</script>

<style scoped>

</style>
