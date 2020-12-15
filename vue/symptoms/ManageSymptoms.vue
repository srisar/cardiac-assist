<template>
  <div class="container-fluid">

    <div class="row justify-content-center">

      <!--
      |
      | start section: add a symptom
      |
      -->
      <div class="col-12 col-lg-6">

        <add-symptom @symptom-added="fetchSymptoms"></add-symptom>

      </div><!--col-->

      <!--
      |
      | start section: add a symptom
      |
      -->
      <div class="col-12 col-lg-6">

        <div class="card">
          <div class="card-header">Existing symptoms</div>
          <div class="card-body">

            <table class="table table-bordered table-striped table-sm" id="table_symptoms">
              <thead>
              <tr>
                <th>Symptom</th>
                <th>Description</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="symptom in symptoms">
                <td>
                  <a @click="btnShowEditModalOnClick(symptom)" href="#">
                    {{ symptom.symptom_name }}
                  </a>
                </td>
                <td v-html="symptom.description"></td>
              </tr>
              </tbody>

            </table>

          </div>
        </div>

      </div><!--col-->

    </div><!--row-->

    <EditSymptom ref="editSymptomModal" :selected-symptom="selectedSymptom"></EditSymptom>


  </div><!--container-->
</template>

<script>

import EditSymptom from "./components/EditSymptom";
import AddSymptom from "./components/AddSymptom";
import ModalWindow from "../_common/ModalWindow";

export default {
  name: "ManageSymptoms",

  components: {
    AddSymptom,
    ModalWindow,
    EditSymptom,
  },

  data() {
    return {
      symptoms: {},
      selectedSymptom: {
        id: undefined,
        symptom_name: undefined,
        description: undefined,
      },
    };
  },

  computed: {
    //
  },

  mounted() {
    /**
     * getting all the symptoms
     */
    this.fetchSymptoms();


  },

  methods: {

    /**
     * fetch all symptoms
     */
    fetchSymptoms: function () {

      axios.get(`${getSiteUrl()}/api/symptom/all`)
          .then(response => {
            return response.data;
          })
          .then(data => {

            this.symptoms = data.symptoms;
          })
          .catch(error => {

            console.log(error);

          });

    },


    btnShowEditModalOnClick(symptom) {
      this.selectedSymptom = symptom;
      this.$refs.editSymptomModal.show();
    }


  }
}
</script>

<style scoped>

</style>