<template>
  <div class="container-fluid">

    <div class="row justify-content-center">

      <!--
      |
      | start section: add a symptom
      |
      -->
      <div class="col-12 col-lg-6">
        <AddDisease @disease-added="fetchDiseases"></AddDisease>
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
                <th style="width: 100px">Disease code</th>
                <th>Disease</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="disease in diseases">
                <td v-html="disease.disease_code"></td>
                <td>
                  <a @click="btnShowEditModalOnClick(disease)" href="#">
                    {{ disease.disease }}
                  </a>
                </td>

              </tr>
              </tbody>

            </table>

          </div>
        </div>

      </div><!--col-->

    </div><!--row-->


    <ModalWindow ref="modal" id="edit_disease_modal">

      <template v-slot:title v-if="selectedDisease">{{ selectedDisease.disease }}</template>

      <section>
        <div v-if="selectedDisease">

          <div class="form-group">
            <label for="field_edit_disease">Disease</label>
            <input type="text" id="field_edit_disease" class="form-control" v-model="selectedDisease.disease">
          </div>

          <div class="form-group">
            <label for="field_edit_disease_code">Disease Code</label>
            <input type="text" class="form-control" id="field_edit_disease_code" v-model="selectedDisease.disease_code">
          </div>

          <div class="form-group">
            <label for="field_description">Description</label>
            <RichEditor ref="editorDescription" id="field_description" v-model="selectedDisease.description"></RichEditor>
          </div>

        </div>
      </section>


      <template v-slot:footer>
        <button type="button" class="btn btn-success" id="btn_update_symptom" :disabled="isEmptySelectedDiseaseName" @click="updateDisease">Update changes</button>
      </template>

    </ModalWindow>

  </div><!--container-->
</template>

<script>

import AddDisease from "./components/AddDisease";
import ModalWindow from "../_common/ModalWindow";
import RichEditor from "../_common/RichEditor";


export default {
  name: "ManageDiseases",
  components: {
    RichEditor,
    ModalWindow,
    AddDisease,
  },

  data() {
    return {
      diseases: undefined,
      disease: {
        id: undefined,
        disease: "",
        disease_code: "",
        description: "",
      },
      selectedDisease: {
        id: undefined,
        disease_code: undefined,
        disease: undefined,
        description: undefined
      },
    };
  },

  computed: {
    isEmptySelectedDiseaseName: function () {
      return _.isEmpty(this.selectedDisease.disease);
    }
  },

  mounted() {
    this.fetchDiseases();
  },

  methods: {

    fetchDiseases: function () {

      axios.get(`${getSiteUrl()}/api/disease/all`)
          .then(response => {

            this.diseases = response.data.diseases;

          })
          .catch(error => {
            showErrorToast("Failed to load diseases");
            console.log(error.response.data);
          });

    },


    updateDisease: function () {

      axios.post(`${getSiteUrl()}/api/disease/update`, {
        id: this.selectedDisease.id,
        disease: this.selectedDisease.disease,
        disease_code: this.selectedDisease.disease_code,
        description: this.selectedDisease.description,

      }).then(response => {

        this.fetchDiseases();
        showSuccessToast('Disease updated');

      }).catch(error => {
        console.log(error.response.data);
        showErrorToast('Failed to update disease');
      })

    },


    btnShowEditModalOnClick: function (disease) {
      this.selectedDisease = disease;
      /** this init() method is needed if multiple instances need to bt swapped. for example, modal window */
      this.$refs.editorDescription.init(this.selectedDisease.description);
      this.$refs.modal.show();
    },


  },
}
</script>

<style scoped>

</style>