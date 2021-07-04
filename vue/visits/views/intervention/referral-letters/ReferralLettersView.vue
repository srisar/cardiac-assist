<template>

  <div>

    <div class="card shadow shadow-sm mb-3">
      <div class="card-header">Existing letters</div>
      <div class="card-body">

        <table class="table table-bordered table-hover">
          <tbody>
          <tr v-for="item in visitLetters" :key="item.id">
            <td>
              <router-link :to="'/referral-letters/edit/' + item.id">{{ item.title }}</router-link>
            </td>
          </tr>
          </tbody>
        </table>

      </div>
    </div>

    <!-- --------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <!-- card: add new referral letter -->
    <div class="card shadow shadow-sm mb-3">

      <div class="card-header">Referral Letters</div>
      <div class="card-body">

        <div class="form-row mb-2">
          <div class="col">

            <div class="form-group">
              <label>Letter model</label>
              <select class="custom-select" v-model="selectedModelId">
                <option value="-1" disabled selected>CHOOSE ONE</option>
                <option v-for="(item, index) in letterModels" :value="index">{{ item.title }}</option>
              </select>
            </div>

            <div class="text-center">
              <button class="btn btn-success" :disabled="selectedModelId === '-1'" @click="onChooseAndUpdate()">
                <img src="/assets/images/actions/forward.svg" class="icon-24" alt=""> Choose
              </button>
            </div>

          </div>
        </div><!-- row -->

        <div class="row mb-2" v-if="isEditReferralSectionOpen">
          <div class="col">

            <RichEditorV2 v-model="selectedLetterToAdd"/>

            <div class="alert alert-secondary my-2">

              <div class="row my-2">
                <div class="col">

                  <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" class="form-control" v-model.trim="fields.doctorName" placeholder="Doctor's name">
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <textarea rows="3" v-model="fields.address" class="form-control" placeholder="Doctor's address"></textarea>
                  </div>

                  <div class="form-group">
                    <label>Diseases</label>
                    <textarea rows="3" v-model="fields.diseases" class="form-control" placeholder="diseases"></textarea>
                  </div>

                  <div class="form-group">
                    <label>Symptoms</label>
                    <textarea rows="3" v-model="fields.symptoms" class="form-control" placeholder="Number of symptoms"></textarea>
                  </div>

                  <div class="form-group">
                    <label>Treatments</label>
                    <textarea rows="3" v-model="fields.treatments" class="form-control" placeholder="Number of treatments"></textarea>
                  </div>

                  <div class="form-group">
                    <label>Diagnoses</label>
                    <textarea rows="3" v-model="fields.diagnoses" class="form-control" placeholder="Number of diagnoses"></textarea>
                  </div>

                  <div class="d-flex justify-content-between">
                    <button class="btn btn-secondary" :disabled="selectedModelId === '-1'" @click="onChooseAndUpdate()">
                      <img src="/assets/images/actions/image.svg" class="icon-24" alt=""> Preview</button>

                  </div>

                </div>
              </div>

            </div><!-- alert -->

            <div class="alert alert-light">

              <div class="form-group">
                <label>Letter title</label>
                <input type="text" class="form-control" v-model.trim="title" placeholder="Title for the letter being added">
              </div>

              <div class="text-center">
                <button class="btn btn-success" :disabled="title.length === 0" @click="onSave()">
                  <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Save</button>
              </div>

            </div>

          </div>
        </div>


      </div>
    </div><!-- card -->


  </div>

</template>

<script>
import RichEditorV2 from "../../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../../_common/bootbox_dialogs";

import voca from "voca";

export default {
  name: "ReferralLettersView",
  components: {RichEditorV2},
  data() {
    return {

      selectedModelId: "-1",
      selectedLetterToAdd: "",
      title: "",

      fields: {
        doctorName: "",
        address: "",
        symptoms: "",
        treatments: "",
        diagnoses: "",
        diseases: "",
      },

      isEditReferralSectionOpen: false,

    }
  },

  computed: {

    visit() {
      return this.$store.getters.getVisit;
    },

    patient() {
      return this.visit.patient;
    },

    letterModels() {
      return this.$store.getters.getLetterModels;
    },

    selectedLetterModel() {
      return this.letterModels[this.selectedModelId];
    },

    visitLetters() {
      return this.$store.getters.getVisitLetters;
    }

  },

  async mounted() {

    /* fetch all letter models */
    try {
      await this.$store.dispatch("visitLetters_fetchAllModels");
    } catch (e) {
      errorMessageBox("Failed to fetch letter models");
    }

    /* fetch all visit letters */
    try {
      await this.$store.dispatch("visitLetters_fetchAll", this.visit.id);
    } catch (e) {
      errorMessageBox("Failed to load patient's referral letters");
    }

  },

  methods: {

    onChooseAndUpdate() {
      this.selectedLetterToAdd = this.updateCommonTemplateTagsValues(this.selectedLetterModel.letter_model);
      this.title = this.selectedLetterModel.title;
      this.isEditReferralSectionOpen = true;
    },


    updateCommonTemplateTagsValues(letterModel) {

      const today = moment().format("YYYY-MM-DD");
      let pronounStart = "He";
      let pronoun = "he";
      let pronounPossessiveStart = "His";
      let pronounPossessive = "his";

      if (this.patient.gender === "FEMALE") {
        pronoun = "she";
        pronounStart = "She";
        pronounPossessive = "her";
        pronounPossessiveStart = "Her";
      }

      let temp = letterModel

      temp = voca.replaceAll(temp, "{DATE}", today);
      temp = voca.replaceAll(temp, "{PATIENT_NAME}", `${this.patient.first_name} ${this.patient.last_name}`);
      temp = voca.replaceAll(temp, "{PRONOUN}", pronoun);
      temp = voca.replaceAll(temp, "{PRONOUN|START}", pronounStart);
      temp = voca.replaceAll(temp, "{PRONOUN|POSSESSIVE}", pronounPossessive);
      temp = voca.replaceAll(temp, "{PRONOUN|POSSESSIVE|START}", pronounPossessiveStart);


      /* add doctor name */
      if (!voca.isEmpty(this.fields.doctorName)) {
        temp = voca.replaceAll(temp, "{DR_NAME}", this.fields.doctorName);
      }

      /* add doctor address */
      if (!voca.isEmpty(this.fields.address)) {
        temp = voca.replaceAll(temp, "{DR_ADDRESS}", voca.replaceAll(this.fields.address, "\n", "<br>"));
      }

      /* add diseases */
      if (!voca.isEmpty(this.fields.diseases)) {
        temp = voca.replaceAll(temp, "{DISEASE}", voca.replaceAll(this.fields.diseases, "\n", "<br>"));
      }

      /* add symptoms */
      if (!voca.isEmpty(this.fields.symptoms)) {
        temp = voca.replaceAll(temp, "{SYMPTOMS}", voca.replaceAll(this.fields.symptoms, "\n", "<br>"));
      }

      /* add diagnoses */
      if (!voca.isEmpty(this.fields.diagnoses)) {
        temp = voca.replaceAll(temp, "{DIAGNOSES}", voca.replaceAll(this.fields.diagnoses, "\n", "<br>"));
      }

      /* add treatments */
      if (!voca.isEmpty(this.fields.treatments)) {
        temp = voca.replaceAll(temp, "{TREATMENT}", voca.replaceAll(this.fields.treatments, "\n", "<br>"));
      }

      return temp;

    },

    /*
    * On save
    * */
    async onSave() {

      try {

        const params = {
          visit_id: this.visit.id,
          title: this.title,
          letter: this.selectedLetterToAdd
        };

        await this.$store.dispatch("visitLetters_add", params);
        this.isEditReferralSectionOpen = false;
        successMessageBox("Letter added");

        /* fetch all visit letters */
        try {
          await this.$store.dispatch("visitLetters_fetchAll", this.visit.id);
        } catch (e) {
          errorMessageBox("Failed to load patient's referral letters");
        }


      } catch (e) {
        errorMessageBox("Failed to save the letter");
      }


    },


  },

}
</script>

<style scoped>

</style>
