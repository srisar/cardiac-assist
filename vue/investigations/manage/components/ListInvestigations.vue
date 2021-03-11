<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div>Investigations</div>
        <div>
          <button class="btn btn-success btn-tiny" @click="onClickAdd">Add a new investigation</button>
        </div>
      </div>

      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-striped">
          <thead>
          <tr>
            <th>Investigation name</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in investigationsList">
            <td><a href="#" @click="setSelected(item)">{{ item.investigation_name }}</a></td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>


export default {
  name      : "ListInvestigations",
  components: {},

  props: [],

  data() {
    return {}
  },

  computed: {

    investigationsList: function () {
      return this.$store.state.investigationsList;
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
      this.$store.dispatch('fetchInvestigations');
    },

    setSelected: function (investigation) {
      this.$store.dispatch('setSelectedInvestigation', investigation);
    },

    onClickAdd: function () {
      this.$store.commit('setPanelModeAdd');
    }

  },

}
</script>

<style scoped>

</style>
