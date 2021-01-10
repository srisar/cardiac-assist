<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header">Symptoms</div>
      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-striped">
          <thead>
          <tr>
            <th>Symptom</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in symptomsList">
            <td><a href="#" @click="viewSelectedSymptom(item)">{{ item.symptom_name }}</a></td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->


    <SelectedSymptomModal :symptom="selectedSymptom" :event-bus="eventBus" @close="onCloseViewSelectedSymptom"/>
  </div><!-- template -->

</template>

<script>

import SelectedSymptomModal from "./SelectedSymptomModal";

export default {
  name: "ListSymptoms",
  components: {SelectedSymptomModal,},

  props: ['eventBus'],

  data() {
    return {
      symptomsList: [],
      selectedSymptom: null,
    }
  },

  computed: {
    //
  },

  mounted() {
    //
    this.fetchAll();

    this.eventBus.$on('symptom-saved', () => {
      this.fetchAll();
    });

    this.eventBus.$on('edit-modal-close', () => {
        this.selectedSymptom = null;
    });

  },

  methods: {
    //

    /*
    * Fetch existing symptoms
    * */
    fetchAll: function () {
      $.get(`${getSiteURL()}/api/get/symptoms.php`)
          .done(r => {
            this.symptomsList = r.data;
          })
          .fail(e => {
            console.log("Error fetching symptoms");
          });
    },

    viewSelectedSymptom: function (symptom) {
      this.selectedSymptom = symptom;
      this.eventBus.$emit('edit-modal-open');
    },

    onCloseViewSelectedSymptom: function () {
      this.selectedSymptom = null;
    }

  },

}
</script>

<style scoped>

</style>
