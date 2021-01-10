<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header">Diseases</div>
      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-striped">
          <tbody>
          <tr v-for="(item, index) in diseasesList">
            <td><a href="#" @click="viewSelectedDisease(item)">{{ item.disease }}</a></td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->

    <SelectedDiseaseModal :event-bus="eventBus"></SelectedDiseaseModal>

  </div><!-- template -->

</template>

<script>

import SelectedDiseaseModal from "./SelectedDiseaseModal";

export default {
  name: "ListDiseases",
  components: {SelectedDiseaseModal},

  props: ['eventBus'],

  data() {
    return {
      diseasesList: [],
    }
  },

  computed: {
    //
  },

  mounted() {
    //
    this.fetchAll();

    this.eventBus.$on('disease-save', () => {
      this.fetchAll();
    });

  },

  methods: {
    //

    /*
    * Fetch existing symptoms
    * */
    fetchAll: function () {
      $.get(`${getSiteURL()}/api/get/diseases.php`)
          .done(r => {
            this.diseasesList = r.data;
          })
          .fail(e => {
            console.log("Error fetching diseases");
          });
    },

    viewSelectedDisease: function (disease) {
      this.eventBus.$emit('open-view-disease-modal', disease);
    },

  },

}
</script>

<style scoped>

</style>
